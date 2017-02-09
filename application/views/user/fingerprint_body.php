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
    <span class="fingerprint_title">My Fingerprint</span>
    <?php print_fingerprint_table($fingerprints); ?>
  </div>
</div>

<script type="text/javascript">
  function regist_fingerprint(form_id)//0~2
  {
    if($('#title_'+form_id).val() == '')
    {
      alert('타이틀을 입력해주세요');
      $('#title_'+form_id).focus();
      return false;
    }

    if($('#title_'+form_id).length > 15)
    {
      alert('타이틀은 최대 15자까지 가능합니다.');
      $('#title_'+form_id).focus();
      return false;
    }

    var fp = new Fingerprint2();
    var index = 1;
    fp.get(function(result, components) {
      for (var property in components) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'fp_'+index++;
        input.value = components[property]['value'];
        $('#fingerprint_form').append(input);
      };

      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'title';
      input.value = $('#title_'+form_id).val();
      $('#fingerprint_form').append(input);

      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'redirect';
      input.value = 'my/fingerprint';
      $('#fingerprint_form').append(input);

      $('#fingerprint_form').submit();
    });
    return true;
  }

  function delete_fingerprint(fp_id)//0~2
  {
    var conf = confirm('Really Wanna Delete??');
    if(conf)
    {
      location.href = '<?=site_url('user/delete_fingerprint')?>'+'/'+fp_id;
    }
  }
</script>
