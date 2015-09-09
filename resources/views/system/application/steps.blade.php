<div class="smpl-step" style="border-bottom: 0; min-width: 500px; margin-bottom: 50px;">
    <div class="col-xs-2 smpl-step-step {{(strpos($current_url, 'add'))? 'active':'complete'}}">
        <div class="smpl-step-num">Step 1</div>
        <div class="progress">
            <div class="progress-bar"></div>
        </div>
                <span class="round-tabs three">
                      <i class="fa fa-users"></i>
                </span>

        <div class="smpl-step-info">Applicant</div>
    </div>
    <div class="col-xs-2 smpl-step-step <?php if(strpos($current_url, 'property')) echo 'active'; elseif(!strpos($current_url, 'add')) echo 'complete'; else echo 'disabled' ?>">
        <div class="smpl-step-num">Step 2</div>
        <div class="progress">
            <div class="progress-bar"></div>
        </div>
                <span class="round-tabs two">
                     <i class="fa fa-home"></i>
                </span>

        <div class="smpl-step-info">Property</div>
    </div>
    <div class="col-xs-2 smpl-step-step <?php if(strpos($current_url, 'other')) echo 'active'; elseif(!strpos($current_url, 'add') && !strpos($current_url, 'property')) echo 'complete'; else echo 'disabled' ?>">
        <div class="smpl-step-num">Step 3</div>
        <div class="progress">
            <div class="progress-bar"></div>
        </div>
                <span class="round-tabs one">
                      <i class="fa fa-gift"></i>
                </span>

        <div class="smpl-step-info">Other Assets</div>
    </div>
    <div class="col-xs-2 smpl-step-step <?php if(strpos($current_url, 'income')) echo 'active'; elseif(!strpos($current_url, 'add') && !strpos($current_url, 'property') && !strpos($current_url, 'other')) echo 'complete'; else echo 'disabled' ?>">
        <div class="smpl-step-num">Step 4</div>
        <div class="progress">
            <div class="progress-bar"></div>
        </div>
                <span class="round-tabs four">
                      <i class="fa fa-money"></i>
                 </span>

        <div class="smpl-step-info">Income</div>
    </div>
    <div class="col-xs-2 smpl-step-step <?php if(strpos($current_url, 'expense')) echo 'active'; elseif(strpos($current_url, 'review')) echo 'complete'; else echo 'disabled' ?>">
        <div class="smpl-step-num">Step 5</div>
        <div class="progress">
            <div class="progress-bar"></div>
        </div>
                <span class="round-tabs five">
                      <i class="fa fa-dollar"></i>
                 </span>

        <div class="smpl-step-info">Expense</div>
    </div>
    <div class="col-xs-2 smpl-step-step <?php if(strpos($current_url, 'review')) echo 'active'; else echo 'disabled' ?>">
        <div class="smpl-step-num">Step 6</div>
        <div class="progress">
            <div class="progress-bar"></div>
        </div>
                <span class="round-tabs six">
                      <i class="fa fa-check"></i>
                 </span>

        <div class="smpl-step-info">Review</div>
    </div>
</div>