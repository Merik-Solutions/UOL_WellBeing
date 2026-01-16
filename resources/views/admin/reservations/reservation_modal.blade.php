
<style>
    .text-blue-dark{
        color: #004f9c;
        font-weight: 600;
    }
</style>
<div class="modal" id="reservation_modal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-xl" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reservation Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="pb-3">
                    <h2>Reservation Info</h2>
                </div>
               
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><b>Doctor Name</b></td>
                            <td><span class="text-blue-dark">{{ $reservation->doctor->name_en }}</span></td>
                        </tr>
                        <tr>
                            <td><b>Patient Name</b></td>
                            <td><span class="text-blue-dark">{{ $reservation->patient->name }}</span></td>
                        </tr>
                        <tr>
                            <td><b>Appt Date</b></td>
                            <td><span class="text-blue-dark">{{ $reservation->date }}</span></td>
                        </tr>
                        <tr>
                            <td><b>Appt Start Time</b></td>
                            <td><span class="text-blue-dark">{{ date('h:i a', strtotime($reservation->from_time)) }}</span></td>
                        </tr>
                        <tr>
                            <td><b>Appt End Time</b></td>
                            <td><span class="text-blue-dark">{{ date('h:i a', strtotime($reservation->to_time)) }}</span></td>
                        </tr>

                          <tr>
                            <td><b>Appt Status</b></td>
                            <td><span class="text-blue-dark">{{ $reservation->status ? ucfirst($reservation->status) : 'n/a' }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>