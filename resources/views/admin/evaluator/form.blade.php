<div class="row"><div class="col-md-12"><div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">开始估价</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form action="{{ route('admin.evaluate.submit') }}" method="post" class="form-horizontal" accept-charset="UTF-8" pjax-container="">

        <div class="box-body">

          <div class="fields-group">

            <div class="col-md-12">
              <div class="form-group {!! !$errors->has('content') ? '' : 'has-error' !!}">
                <label for="content" class="col-sm-2 asterisk control-label">估价内容</label>
                <div class="col-sm-8">
                  @if($errors->has('content'))
                    @foreach($errors->get('content') as $message)
                      <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{$message}}</label><br/>
                    @endforeach
                  @endif
                  <textarea name="content" class="form-control content" rows="5" placeholder="输入 估价内容"></textarea>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          @csrf
          <div class="col-md-2">
          </div>
          <div class="col-md-8">
            <div class="btn-group pull-right">
              <button type="submit" class="btn btn-primary">提交</button>
            </div>
            <div class="btn-group pull-left">
              <button type="reset" class="btn btn-warning">重置</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
