<div class="container-xxl py-3">
    <div class="comtainer">
        <div class="row">
            <div class="col-12 flex justify-content-between gap-1 mb-4">
                <button class="btn btn-sm btn-secondary"><i class="bi bi-plus-circle"></i> New Projects</button>
                <div class="flex justify-content-between gap-1">
                    <button class="btn btn-sm btn-primary">Total Projects</button>
                    <button class="btn btn-sm btn-success">Completed Projects</button>
                    <button class="btn btn-sm btn-warning">Ongoing Projects</button>
                    <button class="btn btn-sm btn-danger">Collapsed Projects</button>
                </div>

            </div>
        </div>

        {{-- Project List --}}
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>SL/NO</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Project Manager</th>
                            <th>Start Date</th>
                            <th>Expected End Date</th>
                            <th>Completed</th>
                            <th>Delay</th>
                            <th>Cost</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>SL/NO</td>
                            <td>Status</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Project Manager</td>
                            <td>Start Date</td>
                            <td>Expected End Date</td>
                            <td>Completed</td>
                            <td>Delay</td>
                            <td>Cost</td>
                            <td>Paid</td>
                            <td>Due</td>
                            <td>Action</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>