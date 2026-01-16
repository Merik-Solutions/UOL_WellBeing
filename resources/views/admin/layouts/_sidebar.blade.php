<div class="left-side-menu">

    <div class="slimscroll-menu">
        <!-- User box -->
        <div class="user-box text-center">

            <div class="dropdown">
                <a href="{!! route('admin.admins.edit', auth()->id()) !!}" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                    data-toggle="dropdown">{!! auth()->guard('admin')->user()->name !!}</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user mr-1"></i>
                        <span>{!! __('My Account') !!}</span>
                    </a>

                    <!-- item-->
                    <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"
                        class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>{!! __('Logout') !!}</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">{!! optional(auth()->user()->role)->label !!}</p>

        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li>
                    <a href="{!! route('admin.dashboard') !!}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span> {!! __('Dashboard') !!} </span>
                    </a>
                </li>
                <li>
                    <a href="{!! route('admin.sale_reports') !!}">
                        <i class=" mdi mdi-file-document-edit-outline"></i>
                        <span> {!! __('Reports') !!} </span>
                    </a>
                </li>          
                <li>
                    <a href="{!! route('admin.settings.index') !!}">
                        <i class="fas fa-cogs"></i> <span> {!! __('Settings') !!} </span>
                    </a>
                </li>    
                <li>
                    <a href="{!! route('admin.contacts.index') !!}">
                        <i class="fas fa-phone"></i> <span> {!! __('Contacts') !!} </span>
                    </a>
                </li>
                <li>
                    <a href="{!! route('admin.admins.index') !!}">
                        <i class="fab fa-black-tie"></i>
                        <span> {!! __('Admins') !!} </span>
                    </a>
                </li>
                <li>
                    <a href="{!! route('admin.roles.index') !!}">
                        <i class="fab fa-black-tie"></i>
                        <span> {!! __('Roles') !!} </span>
                    </a>
                </li>
                <li>
                    <a href="{!! route('admin.permissions.index') !!}">
                        <i class="fab fa-black-tie"></i>
                        <span> {!! __('Permissions') !!} </span>
                    </a>
                </li>
                <li>
                    <a href="{!! route('admin.categories.index') !!}">
                        <i class=" fas fa-boxes"></i>
                        <span> {!! __('Categories') !!} </span>
                    </a>
                </li>
                <li>
                    <a href="{!! route('admin.countries.index') !!}">
                        <i class=" fas fa-boxes"></i>
                        <span> {!! __('Countries') !!} </span>
                    </a>
                </li>
                <li>
                    <a href="{!! route('admin.promocodes.index') !!}">
                        <i class="fas fa-money-bill-alt"></i>
                        <span> {!! __('Promocodes') !!} </span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);">
                        <i class="fas fa-book-medical"></i>
                        <span> {!! __('Medical Record') !!} </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav2-second" aria-expanded="false">
                        <li>
                            <a href="{!! route('admin.chats.index') !!}">
                                {!! __('Chats') !!}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.get_prescriptions')}}">
                                <span> {!! __('Prescription') !!} </span>
                            </a>
                        </li>
                        <li>
                            <a href="{!! route('admin.clinical_notes') !!}">
                                <span> {!! __('Clinical Notes') !!} </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);">
                        <i class="fas fa-desktop"></i>
                        <span> {!! __('Monitoring') !!} </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav2-second" aria-expanded="false">
                        <li>
                            <a href="{!! route('admin.reservations.index') !!}">
                                {!! __('Reservations') !!}
                            </a>
                        </li>
                        <li>
                            <a href="{!! route('admin.message_packages') !!}">
                                <span> {!! __('Message Packages') !!} </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{!! route('admin.notifications.index') !!}">
                        <i class="fas fa-bell"></i>
                        <span> {!! __('Notifications') !!} </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.payments') }}">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span> {!! __('Payments') !!} </span>
                    </a>
                </li>
                <li>
                    <a href="{!! route('admin.dispute_center') !!}">
                        <i class="fas fa-info"></i>
                        <span class="badge badge-danger float-right">
                            {{ \App\Models\ComplaintOrFeedback::where('status', \App\Models\ComplaintOrFeedback::STATUS_PENDING)->count() }}
                        </span>
                        <span> {!! __('Dispute Center') !!} </span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{!! route('admin.withdraw-requests.index') !!}">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span class="badge badge-danger float-right">
                            {{ \App\Models\WithdrawRequest::where('status', \App\Models\WithdrawRequest::WAITING)->count() }}

                        </span>

                        <span> {!! __('Withdraw Requests') !!} </span>
                    </a>
                </li> --}}
                {{-- <li>
                    <a href="{{ route('admin.refunds') }}">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span> {!! __('Refund Requests') !!} </span>
                    </a>
                </li> --}}
                <li>
                    <a href="{!! route('admin.transactions') !!}">
                        <i class="fas fa-dollar-sign"></i>


                        <span> {!! __('Transactions') !!} </span>
                    </a>
                </li>
                <li>
                    <a href="{!! route('admin.users.index') !!}">

                        <i class="fas fa-heartbeat pr-1"></i>
                        {!! __('Users') !!}</a>
                </li>
                <li>               
                    <a href="{!! route('admin.doctors.index') !!}">
                        <i class="fas fa-stethoscope"></i>
                        <span> {!! __('Doctors') !!} </span>
                    </a>
                </li>
                {{-- <li>              
                    <a href="{!! route('admin.reservations.index') !!}">
                        <i class="fas fa-stethoscope"></i>
                        <span> {!! __('Reservations') !!} </span>
                    </a>
                </li> --}}
                <li>
                    <a href="{!! route('admin.packages.index') !!}">
                        <i class="fas fa-stethoscope"></i>
                        <span> {!! __('Packages') !!} </span>
                    </a>
                </li>
                {{-- <li>          
                    <a href="{!! route('admin.message_packages') !!}">
                        <i class="fas fa-envelope"></i>
                        <span> {!! __('Message Packages') !!} </span>
                    </a>
                </li> --}}
          
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
