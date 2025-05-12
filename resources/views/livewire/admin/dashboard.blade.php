<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Employees</h6>
                            <h3 class="mb-0">142</h3>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> 5.2% from last month</small>
                        </div>
                        <div class="icon primary">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Active Projects</h6>
                            <h3 class="mb-0">24</h3>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> 3 new this week</small>
                        </div>
                        <div class="icon success">
                            <i class="bi bi-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Pending Tasks</h6>
                            <h3 class="mb-0">87</h3>
                            <small class="text-danger"><i class="bi bi-arrow-down"></i> 12 overdue</small>
                        </div>
                        <div class="icon warning">
                            <i class="bi bi-list-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Revenue</h6>
                            <h3 class="mb-0">$245K</h3>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> 12.5% from last quarter</small>
                        </div>
                        <div class="icon danger">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Main Content -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Project Status</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            This Month
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Week</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="projectChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Task Progress</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Website Redesign</span>
                            <span>75%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Mobile App Development</span>
                            <span>42%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 42%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>API Integration</span>
                            <span>90%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 90%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Database Migration</span>
                            <span>30%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 30%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>UI/UX Research</span>
                            <span>65%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 65%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities and Employees -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activities</h5>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="user-avatar">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Sarah Johnson <small class="text-muted ms-2">2 mins ago</small></h6>
                                <p class="mb-0">Completed the dashboard design for Client A</p>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="user-avatar">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">John Doe <small class="text-muted ms-2">15 mins ago</small></h6>
                                <p class="mb-0">Submitted the monthly report for review</p>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <img src="https://randomuser.me/api/portraits/men/75.jpg" class="user-avatar">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Michael Chen <small class="text-muted ms-2">1 hour ago</small></h6>
                                <p class="mb-0">Fixed critical bug in the payment module</p>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <img src="https://randomuser.me/api/portraits/women/68.jpg" class="user-avatar">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Emily Wilson <small class="text-muted ms-2">3 hours ago</small></h6>
                                <p class="mb-0">Started new project "E-commerce Platform"</p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img src="https://randomuser.me/api/portraits/men/22.jpg" class="user-avatar">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">David Kim <small class="text-muted ms-2">5 hours ago</small></h6>
                                <p class="mb-0">Deployed version 2.5 to production</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Team Members</h5>
                    <button class="btn btn-sm btn-outline-primary">View All</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="user-avatar me-2">
                                            <span>Sarah Johnson</span>
                                        </div>
                                    </td>
                                    <td>UI/UX Designer</td>
                                    <td>Design</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="user-avatar me-2">
                                            <span>John Doe</span>
                                        </div>
                                    </td>
                                    <td>Project Manager</td>
                                    <td>Management</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://randomuser.me/api/portraits/men/75.jpg" class="user-avatar me-2">
                                            <span>Michael Chen</span>
                                        </div>
                                    </td>
                                    <td>Backend Developer</td>
                                    <td>Development</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://randomuser.me/api/portraits/women/68.jpg" class="user-avatar me-2">
                                            <span>Emily Wilson</span>
                                        </div>
                                    </td>
                                    <td>Frontend Developer</td>
                                    <td>Development</td>
                                    <td><span class="badge bg-warning">On Leave</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://randomuser.me/api/portraits/men/22.jpg" class="user-avatar me-2">
                                            <span>David Kim</span>
                                        </div>
                                    </td>
                                    <td>DevOps Engineer</td>
                                    <td>Operations</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>