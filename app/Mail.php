<?php

namespace Sphere;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Sphere\Parsers\Mail_RFC822 as MailParser;
use Carbon\Carbon;
use DateTime;
use File;

use Illuminate\Support\Facades\Mail as Mailer;

class Mail extends Model
{

    protected $casts = [
      'recipients' => 'json',
      'sender'     => 'json',
      'files'      => 'json',
      'sent_at'    => 'datetime',
      'spam'       => 'boolean',
    ];
  
    protected $fillable = ['message_id'];
  
    protected $file = [];
  
    public function mailRecipients()
    {
      return $this->hasMany(MailRecipient::class);
    }
  
    public function user()
    {
      return $this->belongsTo(User::class);
    }
  
    public function site()
    {
      return $this->belongsTo(Site::class);
    }
  
    public function group()
    {
      return $this->belongsTo(Group::class);
    }
  
    public function fromUser()
    {
      return $this->belongsTo(User::class, 'from_user_id');
    }
  
    public function getHashidAttribute()
    {
      return 'hashid-'.$this->id;
    }

    public function getMailField($key)
    {
        return array_get($this->file, $key);
    }
  
    public static function parseAddresses($addresses)
    {
      if (empty($addresses)) {
        return null;
      }
      
      $addresses = with(new MailParser($addresses))->parseAddressList();
      $output = [];
            
      foreach ($addresses as $address)
      {
        if (isset($address->groupname)) {
          foreach($address->addresses as $groupAddress) {
            $email = $groupAddress->mailbox.'@'.$groupAddress->host;
            $output[$email] = trim($groupAddress->personal, '"') ?: $email;
          }
        }
        else {
          $email = $address->mailbox.'@'.$address->host;
          $output[$email] = trim($address->personal, '"') ?: $email;
        }
      }
      
      return $output;
    }
  
  public function setSentAtAttribute($sentAt)
  {
    $this->attributes['sent_at'] = Carbon::createFromFormat(DateTime::RFC2822, $sentAt);
  }
  
    public static function newFromMailgun(Request $request)
    {
      $instance = static::firstOrNew(['message_id' => $request->get('Message-Id')]);
      
      $instance->file = $request->all();
      
      if (!$instance->exists) {
        $instance->subject     = $instance->getMailField('Subject');
        $instance->body_text   = $instance->getMailField('stripped-text');
        $instance->body_html   = $instance->getMailField('stripped-html');
        $instance->message_id  = $instance->getMailField('Message-Id');
        $instance->in_reply_to = $instance->getMailField('In-Reply-To');
        $instance->references  = $instance->getMailField('References');
        
        $instance->sender      = [
          'from'     => static::parseAddresses($instance->getMailField('From')),
          'sender'   => static::parseAddresses($instance->getMailField('Sender')),
          'reply_to' => static::parseAddresses($instance->getMailField('Reply-To')),
        ];
        
        $sender = static::getFirstEmail($instance->sender['from']);
        
        if ($user = User::where('email', $sender)->first()) {
          $instance->fromUser()->associate($user);
        }
                
        $instance->sent_at     = $instance->getMailField('Date');
        $instance->spam        = (bool) $instance->getMailField('X-Mailgun-Sflag', false);
      }
      
      $instance->recipients = [
        'to'  => $instance->parseAddresses($instance->getMailField('To')),
        'cc'  => $instance->parseAddresses($instance->getMailField('Cc')),
        'bcc' => $instance->parseAddresses($instance->getMailField('Bcc')),
      ];
      
      $filename = $instance->filename;
      
      $instance->addFile($filename);
      $instance->saveFile($filename);

      return $instance;
    }
  
    public function thread()
    {
      return $this->belongsTo(Mail::class, 'references', 'references');
    }
  
    public function lastMessage()
    {
      return $this->belongsTo(Mail::class, 'in_reply_to', 'in_reply_to');
    }
  
    public static function getFirstEmail(array $addresses)
    {
      foreach ($addresses as $sender => $name) {
        return $sender;
      }
    }
  
    public function saveFile($filename)
    {
      return File::put(storage_path('mail/'.$filename), $this->asJson($this->file));
    }
  
    public function loadFile($filename)
    {
      return $this->fromJson(File::get(storage_path('mail/'.$filename)));
    }
  
    public function getDirectoryAttribute()
    {
      return Carbon::now()->format('Y/m/d/H');
    }
  
    public function getFilenameAttribute()
    {
      $dir = $this->directory;
      
      File::makeDirectory(storage_path('mail/'.$dir), 0755, true, true);
      
      return $dir.'/'.Carbon::now()->format('is').'_'.str_slug($this->message_id, '-').'_'.str_random(8).'.json';
    }
  
    public function addFile($filename)
    {
      $files = $this->files;
      $files[] = $filename;
      return $this->files = $files;
    }
  
    public function makeRecipients()
    {
      $mailRecipients = $this->mailRecipients;
      
      $types = ['to', 'cc', 'bcc'];
      
      foreach ($types as $type) {
        foreach ((array) $this->recipients[$type] as $address => $name) {
          $mailRecipient = MailRecipient::firstOrNewFromAddress($this, $address, $name, $type);
          $mailRecipient->save();
        }
      }
      
      $types = ['from', 'sender', 'reply_to'];
      
      foreach ($types as $type) {
        foreach ((array) $this->sender[$type] as $address => $name) {
          $mailRecipient = MailRecipient::firstOrNewFromAddress($this, $address, $name, $type);
          $mailRecipient->save();
        }
      }
      
    }
  
//   public function makeUserRecipient(User $user)
//   {
    
//     $existing = $this->mailRecipients->filter(function($mailRecipient) use ($user) {
//        return $mailRecipient->user->id == $user->id;
//     });
    
//     if ($existing->count() == 0) {
//       $mailRecipient = new MailRecipient;
//       $mailRecipient->mail()->associate($this);
//       $mailRecipient->user()->associate($user);
//       $mailRecipient->type = $mailRecipient->getRecipientType($this);
//       $mailRecipient->save();
//     }
//     else {
//       foreach ($existing as $mailRecipient) {
//         $mailRecipient->touch();
//       }
//     }

//   }
  
//   public function makeSiteUserRecipient(Site $site, User $user)
//   {
//     $existing = $this->mailRecipients->filter(function($mailRecipient) use ($site, $user) {
//        return ($mailRecipient->site->id == $site->id && $mailRecipient->user->id == $user->id);
//     });
    
//     if ($existing->count() == 0) {
//       $mailRecipient = new MailRecipient;
//       $mailRecipient->mail()->associate($this);
//       $mailRecipient->site()->associate($site);
//       $mailRecipient->user()->associate($user);
//       $mailRecipient->type = $mailRecipient->getRecipientType($this);
//       $mailRecipient->save();
//     }
//     else {
//       foreach ($existing as $mailRecipient) {
//         $mailRecipient->touch();
//       }
//     }
//   }
  
  public function makeSiteGroupRecipients(Site $site, Group $group)
  {
    return;  //FIXME
    foreach ($group->all_member_users as $user) {
      $existing = $this->mailRecipients->filter(function($mailRecipient) use ($site, $group, $user) {
         return ($mailRecipient->site->id == $site->id && $mailRecipient->group->id == $group->id && $mailRecipient->user->id == $user->id);
      });
          
    if ($existing->count() == 0) {
      $mailRecipient = new MailRecipient;
      $mailRecipient->mail()->associate($this);
      $mailRecipient->site()->associate($site);
      $mailRecipient->group()->associate($group);
      $mailRecipient->user()->associate($user);
      $mailRecipient->type = $mailRecipient->getRecipientType($this);
      $mailRecipient->save();
    }
    else {
      foreach ($existing as $mailRecipient) {
        $mailRecipient->touch();
      }
    }
      
    }
    
  }
  
  public function sendUnsentRecipients()
  {

    $mail = $this->fresh(['mailRecipients']);
    $unsent = $mail->mailRecipients()->where('sent_at', null)->whereIn('type', ['to', 'cc', 'bcc'])->get();
    
    foreach ($unsent as $mailRecipient) {
      Mailer::raw(null, function ($message) use($mailRecipient, $mail) {
          $message->subject($mail->subject);
          $message->setBody($mail->body_html, 'text/html');
          $message->addPart($mail->body_text, 'text/plain');
        
              foreach ($mail->mailRecipients as $otherRecipient) {
                $type = $otherRecipient->type;
                $address = $otherRecipient->address;
                
                if (in_array($type, ['to', 'cc', 'bcc'], true)) {
                
                  if ($otherRecipient->id == $mailRecipient->id) {
                    $message->$type($address['actual'], $address['name']);
                  }
                  else {
                    $message->$type($address['address'], $address['name'].' 🔵');//Ⓢ
                  }
                
                }
                elseif (in_array($type, ['from', 'reply_to'], true)) {
                  $type = studly_case($type);
                  
                  $message->$type($address['address'], $address['name'].' 🔵');//Ⓢ
                }
                
                if (config('app.debug')) {
                  $message->setBody(json_encode(['to' => $message->getTo(),
                                                 'cc' => $message->getCc(),
                                                 'bcc' => $message->getBcc(),
                                                 'from' => $message->getFrom(),
                                                 'sender' => $message->getSender(),
                                                 'reply_to' => $message->getReplyTo(),
                                                ], JSON_PRETTY_PRINT), 'text/plain');
                }
            }
        
          $message->sender('sphere@sphere.loc', 'Sphere 🔵');//Ⓢ
          $message->setId($mail->message_id);
//           $message->setId($mail->in_reply_to);
//           $message->setId($mail->references);
        
          $message->getHeaders()->addTextHeader('X-Sphere-Relay', $mail->hashid);
      });
      $mailRecipient->sent_at = $mailRecipient->freshTimestamp();
      $mailRecipient->save();
    }
  }
  
}
