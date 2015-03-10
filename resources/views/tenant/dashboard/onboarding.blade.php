<!-- COMPOSE MESSAGE MODAL -->
    <div class="modal fade" id="compose-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"  role="dialog" aria-hidden="ture">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
            <h4 class="modal-title"><i class="fa fa-info"></i> On-boarding message</h4>
          </div>
          	<div class="modal-body">
          		Instructions go here ...
      		</div>

          	<div class="modal-footer clearfix">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Got it!</button>
            </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<!-- For first time users -->

<script type="text/javascript">
( function($) {
	$(window).load(function(){
        $('#compose-modal').modal('show');
    });
} ) ( jQuery );
</script>