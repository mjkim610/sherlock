<?php
  if ($this->session->flashdata('errors'))
  {
    echo $this->session->flashdata('errors');
  }
  if ($this->session->flashdata('message'))
  {
    echo "<div class='alert'>";
    echo "<span class='closebtn'>&times;</span>";
    echo "<span>".$this->session->flashdata('message')."</span>";
    echo "</div>";
  }
?>
<div class="row">
  <div class="col-sm-10 col-sm-offset-1">
    <form class="form-horizontal" action="<?=site_url('provider/regist_submit')?>" method="post" onsubmit="return check_provider_regist_form();">
      <div class="form-group">
        <label class="col-sm-2 control-label">Service Name</label>
        <div class="col-sm-10">
          <input class="form-control" id="service_name" name="service_name" type="text" <?=($state == 'edit')? 'disabled':''?> value="<?=isset($service)? $service->service_name:''?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Service Description</label>
        <div class="col-sm-10">
          <input class="form-control" id="description" name="description" type="text" value="<?=isset($service)? $service->description:''?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">URL</label>
        <div class="col-sm-10">
          <input class="form-control" id="url" name="url" type="text" value="<?=isset($service)? $service->url:''?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Redirect URL</label>
        <div class="col-sm-10">
          <input class="form-control" id="redirect_url" name="redirect_url" type="text" value="<?=isset($service)? $service->redirect_url:''?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Threshold 1</label>
        <div class="col-sm-10">
          <input class="form-control" id="threshold_1" name="threshold_1" type="number" min="0" max="100" value="<?=isset($service)? $service->threshold_1:''?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Threshold 2</label>
        <div class="col-sm-10">
          <input class="form-control" id="threshold_2" name="threshold_2" type="number" min="0" max="100" value="<?=isset($service)? $service->threshold_2:''?>">
        </div>
      </div>
      <button class="btn btn-default pull-right" type="submit">Submit</button>
      <?php if(isset($service)): ?>
        <input type="hidden" name="app_id" value="<?=$service->app_id?>">
      <?php endif; ?>
      <input type="hidden" name="state" value="<?=$state?>">
      <input type="hidden" name="redirect" value="<?= $this->uri->uri_string() ?>">
    </form>
  </div>
</div>

<script type="text/javascript">
  function check_provider_regist_form()
  {

  }
</script>
