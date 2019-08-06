
{if $flash['flash']==true}
    <div class="col-md-8">
            <div class="alert alert-success">
                {$flash['message']}
            </div>
    </div>
{/if}

<style type="text/css">

    legend {

        padding-top: 10px;
    }
</style>
<div class="col-md-6">
    <div>

        <form action="index.php?page=ploader&plugin=FreiChat" role="form" method="post" enctype="multipart/form-data">

            <div class="box box-info">
                <fieldset class="box-body">
                    <legend>FreiChat Settings</legend>
                    <label>Secret Key</label>
                    <input type="text" class="form-control" name="FREICHAT_APP_KEY" value="{"FREICHAT_APP_KEY"|get_opt}" /><br/>

                    <label>Please do not change the secret key unless you are told to do so.

                    </label>
                </fieldset>
            </div>

            <input type="hidden" name="CSRF_token" value="{$token}" />
            <input type="submit" value="Save" class="btn btn-primary"/>
        </form>
        <br/>
        <br/>
    </div>
</div>