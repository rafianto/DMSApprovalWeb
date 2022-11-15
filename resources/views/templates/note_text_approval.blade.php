<div class="modal fade" tabindex="-1" id="modalFormNoteApproval" 
    aria-labelledby="modalFormNoteApprovalLabel" aria-hidden="false"
    data-backdrop="static" data-keyboard="false"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormNoteApprovalLabel">Approval Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formNoteApproval">
            <div class="form-group">
                <label for="noteText">Note</label>
                <textarea class="form-control" name="note" 
                    id="noteText" rows="3"
                ></textarea>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="sendApprovalBtn" onclick="sendApproval()">Send</button>
      </div>
    </div>
  </div>
</div>