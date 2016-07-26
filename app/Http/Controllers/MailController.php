<?php

namespace Sphere\Http\Controllers;

use Illuminate\Http\Request;

use Sphere\Http\Requests;

use Sphere\Site;
use Sphere\User;
use Sphere\Group;
use Sphere\Mail;
use Sphere\MailRecipient;

use File;

class MailController extends Controller
{ 
    public function user(Request $request, User $user)
    {
      $mail = Mail::newFromMailgun($request);
      $mail->save();
      
      $mail->makeRecipients();
//       $mail->makeUserRecipient($user);
      
      $mail->sendUnsentRecipients();
      
    }
    public function siteUser(Request $request, Site $site, User $user)
    {
      if (!$user->sites->contains($site))
      {
        abort(406);
      }
      
      $mail = Mail::newFromMailgun($request);
      $mail->save();
      
      $mail->makeRecipients();
//       $mail->makeSiteUserRecipient($site, $user);
      
      $mail->sendUnsentRecipients();
      
    }
    public function siteGroup(Request $request, Site $site, Group $group)
    {
      if ($group->site->id != $site->id)
      {
        abort(406);
      }
      
      $mail = Mail::newFromMailgun($request);
      $mail->save();
      
      $mail->makeRecipients();
//       $mail->makeSiteGroupRecipients($site, $group);
      
      $mail->sendUnsentRecipients();
      
    }

}
