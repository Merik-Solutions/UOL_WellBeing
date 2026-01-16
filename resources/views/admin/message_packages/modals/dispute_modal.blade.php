<div class="modal fade" id="dispute_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Dispute Details Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body p-3">
          <form id="add_dispute_form" action="javascript:add_dispute()">
            @csrf
            <input id="package_id" type="hidden" name="package_id">

            {{-- <div class="form-group">
                <label for="">Type</label>
                <select class="form-control" name="type" id="" required>
                    <option disabled selected>Select type</option>
                    <option value="feedback">Feedback</option>   
                    <option value="complaint">Complaint</option>   
                </select>
            </div> --}}

            <div class="form-group">
                <label for="">Reason</label>
                <textarea class="form-control" name="reason" id="" cols="30" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="">Remarks</label>
                <textarea class="form-control" name="remarks" id="" cols="30" rows="4"></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary float-right">Save changes</button>
            </div>
                
            </form>
        </div>
        
    </div>
</div>