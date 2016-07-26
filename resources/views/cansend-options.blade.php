<div class="panel-heading">
    <h3 class="panel-title">
        User
    </h3>
</div>
<div class="panel-body">
    <p>Who can send me messages through Sphere?</p>
    <div class="row">
        <div class="col-md-2">
            <span class="text-muted">Less Secure</span>
        </div>
        <div class="col-md-6">
            <div class="radio">
                <label  class="text-danger">
                    <input type="radio" name="can[send][user]" value="anyone"> Anyone on the internet.
                </label>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <div class="radio">
                <label >
                    <input type="radio" name="can[send][user]" value="sphere"> Any Sphere user.
                </label>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <div class="radio">
                <label >
                    <input type="radio" name="can[send][user]" value="sites"> Any member of sites I am a member of.
                </label>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <div class="radio">
                <label >
                    <input type="radio" name="can[send][user]" value="friends" checked> Only my friends.
                </label>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <div class="checkbox">
                <label>
                    <input type="checkbox" disabled checked> Authorised members of site groups I am a member of.
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <span class="text-muted">More Secure</span>
        </div>
        <div class="col-md-6">
            <div class="checkbox">
                <label>
                    <input type="checkbox" disabled checked> Administrators of my sites.
                </label>
            </div>
        </div>
    </div>
</div>
<div class="panel-heading">
    <h3 class="panel-title">
        Group
    </h3>
</div>
<div class="panel-body">
    <p>Who can send messages to this group?</p>
    <div class="row">
        <div class="col-md-2">
            <span class="text-muted">Less Secure</span>
        </div>
        <div class="col-md-6">
            <div class="radio">
                <label  class="text-danger">
                    <input type="radio" name="can[send][group]" value="anyone"> Anyone on the internet.
                </label>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <div class="radio">
                <label >
                    <input type="radio" name="can[send][group]" value="sphere"> Any Sphere user.
                </label>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <div class="radio">
                <label >
                    <input type="radio" name="can[send][group]" value="site"> Any member of this site.
                </label>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <div class="radio">
                <label >
                    <input type="radio" name="can[send][group]" value="group"> Any member of this group.
                </label>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <div class="radio">
                <label >
                    <input type="radio" name="can[send][group]" value="auth" checked> Authorised members of this group.
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <span class="text-muted">More Secure</span>
        </div>
        <div class="col-md-6">
            <div class="checkbox">
                <label>
                    <input type="checkbox" disabled checked> Administrators of this site.
                </label>
            </div>
        </div>
    </div>
</div>