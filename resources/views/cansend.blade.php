@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form class="form" action="" method="POST">
        <div class="panel panel-default">
            {{ method_field('PUT') }}
            
            @include('cansend-options')
              
          <div class="panel-footer">
            <div class="row">
              <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="" class="btn btn-link">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </form>
        <a href="http://twigfiddle.com/noimvw">http://twigfiddle.com/noimvw</a>
    </div>
  </div>
</div>
@endsection

{{--
{% for record in records %}
<div class="panel-heading">
	<h3 class="panel-title">
		{{ record.record }}
	</h3>
</div>
<div class="panel-body">
	<p>{{ record.message }}</p>
{% for option in record.options %}
	<div class="row">
		<div class="col-md-2">
{% if loop.first %}
			<span class="text-muted">Less Secure</span>
{% elseif loop.last %}
			<span class="text-muted">More Secure</span>
{% endif %}
		</div>
		<div class="col-md-6">
{% if option.value in ['admin', 'groups'] %}
			<div class="checkbox">
				<label>
					<input type="checkbox" disabled checked> {{ option.label }}
				</label>
			</div>
{% else %}
			<div class="radio">
				<label {% if option.value == 'anyone' %} class="text-danger"{% endif %}>
					<input type="radio" name="{{ record.name }}" value="{{ option.value }}"{% if option.default %} checked{% endif %}> {{ option.label }}
				</label>
			</div>
{% endif %}
{% if option.except %}

{% endif %}
		</div>
	</div>
{% endfor %}
</div>
{% endfor %}
--}}

{{--
{
    "records": [
        {
            "record": "User",
            "name": "can[send][user]",
            "message": "Who can send me messages through Sphere?",
            "options": [
                {
                    "value": "anyone",
                    "label": "Anyone on the internet.",
                    "help": "",
                    "except": true
                },
                {
                    "value": "sphere",
                    "label": "Any Sphere user.",
                    "help": "",
                    "except": true
                },
                {
                    "value": "sites",
                    "label": "Any member of sites I am a member of.",
                    "help": "",
                    "except": true
                },
                {
                    "value": "friends",
                    "label": "Only my friends.",
                    "help": "",
                    "except": true,
                    "default": true
                },
                {
                    "value": "groups",
                    "label": "Authorised members of site groups I am a member of.",
                    "help": ""
                },
                {
                    "value": "admin",
                    "label": "Administrators of my sites.",
                    "help": ""
                }
            ]
        },
        {
            "record": "Group",
            "name": "can[send][group]",
            "message": "Who can send messages to this group?",
            "options": [
                {
                    "value": "anyone",
                    "label": "Anyone on the internet.",
                    "help": "Announcement list.",
                    "except": true
                },
                {
                    "value": "sphere",
                    "label": "Any Sphere user.",
                    "help": "Announcement list.",
                    "except": true
                },
                {
                    "value": "site",
                    "label": "Any member of this site.",
                    "help": "Announcement list.",
                    "except": true
                },
                {
                    "value": "group",
                    "label": "Any member of this group.",
                    "help": "Discussion list.",
                    "except": true
                },
                {
                    "value": "auth",
                    "label": "Authorised members of this group.",
                    "help": "Limited announcement list.",
                    "default": true
                },
                {
                    "value": "admin",
                    "label": "Administrators of this site.",
                    "help": "Restricted announcement list."
                }
            ]
        }
    ]
}
--}}