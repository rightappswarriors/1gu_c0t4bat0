<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" style="text-align: center;">
            <div class="image">
                <img src="{{url('images/guihulngan.png')}}" class="img-circle" alt="logo" style="max-width: 85px;">
            </div>
            <!-- <div class="pull-left info">
          <p>Admin</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div> -->
        </div>
        <!-- search form -->
        {{-- <form action="#" method="get" class="sidebar-form" style="margin: 0px 5px 5px 5px;">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> --}}
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        @php
            $LA_GRP = Session::get('grp_ri');
        @endphp
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="">
                <a href="{{ url('') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            @if($LA_GRP["M0000000"]["restrict"] == 'Y')
            <li class="treeview" id="SideBar_MFile">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Master File</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if($LA_GRP["M1000000"]["restrict"] == 'Y')
                    <li id="TreeView_MasterFile_Accounting" class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o" id="SideBar_MFile_Accounting"></i>
                            <span>Accounting</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                              <!-- <span class="label label-primary pull-right">4</span> -->
                            </span>
                        </a>
                        <ul class="treeview-menu" id="TreeView_MasterFile_Accounting_Menu" style="white-space: normal;">
                            @if($LA_GRP["M1000001"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/fund') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Fund"></i> Fund</a></li>
                            @endif
                            @if($LA_GRP["M1000002"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/main-account') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Main_Account"></i> Main Account</a></li>
                            @endif
                            @if($LA_GRP["M1000003"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/sub-account') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Sub_Account"></i> Sub Account</a></li>
                            @endif
                            @if($LA_GRP["M1000004"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/account-group') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Account_Group"></i> Account Group</a></li>
                            @endif
                            @if($LA_GRP["M1000005"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/account-title') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Account_Title"></i> Account Title</a></li>
                            @endif
                            @if($LA_GRP["M1000006"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/journal') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Journal"></i> Journal</a></li>
                            @endif
                            @if($LA_GRP["M1000007"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/debtors') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Debtor"></i> Debtors</a></li>
                            @endif
                            @if($LA_GRP["M1000008"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/creditors') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Creditor"></i> Creditors</a></li>
                            @endif
                            @if($LA_GRP["M1000009"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/cost-center') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Cost_Center"></i> Office</a></li>
                            @endif
                            @if($LA_GRP["M1000010"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/sub-cost-center') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Sub_Cost_Center"></i> Sub Cost Center</a></li>
                            @endif
                            {{-- @if($LA_GRP["M1000011"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/accounting-periods') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Accounting_Period"></i> Accounting Periods</a></li>
                            @endif --}}
                            @if($LA_GRP["M1000012"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/budget-period') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Budget_Period"></i> Budget Period</a></li>
                            @endif
                            @if($LA_GRP["M1000013"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/accounting/charges') }}"><i class="fa fa-circle-o" id="SideBar_MFile_Accounting_Charge"></i> Charges</a></li>
                            @endif
                            @if($LA_GRP["M1000014"]["restrict"] == 'Y')
                            <li><a href="{{url('master-file/accounting/or_types')}}"><i class="fa fa-circle-o" id="SideBar_MFile_OR_TYPE"></i> OR Types</a></li>
                            @endif
                            @if($LA_GRP["M1000015"]["restrict"] == 'Y')
                            <li><a href="{{url('master-file/accounting/sector')}}"><i class="fa fa-circle-o" id="SideBar_MFile_SECTOR"></i> Sector</a></li>
                            @endif
                            <li><a href="{{url('master-file/accounting/function')}}"><i class="fa fa-circle-o" id="SideBar_MFile_FUNCTION"></i> Function</a></li>
                            <li><a href="{{url('master-file/accounting/fpp')}}"><i class="fa fa-circle-o" id="SideBar_MFile_FPP"></i> FPP</a></li>
                            @if($LA_GRP["M2000001"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/tax/group') }}"><i class="fa fa-circle-o" id="SideBar_MFile_TAXGROUP"></i> Tax Group</a></li>
                            @endif
                            @if($LA_GRP["M2000001"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/tax/type') }}"><i class="fa fa-circle-o" id="SideBar_MFile_TAXTYPE"></i> Tax Type </a></li>
                            @endif
                            @if($LA_GRP["M2000001"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/real-property-classification') }}"><i class="fa fa-circle-o" id="SideBar_MFile_RPCLASS"></i> Real type classification </a></li>
                            @endif

                        </ul>
                    </li>
                    @endif
                    @if($LA_GRP["M2000000"]["restrict"] == 'Y')
                    <li class="treeview" id="TreeView_MasterFile_Inventory_Menu">
                        <a href="#">
                            <i class="fa fa-circle-o" id="SideBar_MFile_Inventory"></i>
                            <span>Inventory</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                              <!-- <span class="label label-primary pull-right">4</span> -->
                            </span>
                        </a>
                        <ul class="treeview-menu" style="white-space: normal;" id="TreeView_MasterFile_Inventory_Menu2">
                            @if($LA_GRP["M2000001"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/inventory/brand_name') }}"><i class="fa fa-circle-o" id="SideBar_MFile_BRAND_NAME"></i> Brand Name</a></li>
                            @endif
                            @if($LA_GRP["M2000002"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/inventory/generic_name') }}"><i class="fa fa-circle-o" id="SideBar_MFile_GENERIC_NAME"></i> Generic Name</a></li>
                            @endif
                            @if($LA_GRP["M2000003"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/inventory/item_category') }}"><i class="fa fa-circle-o" id="SideBar_MFile_ITEM_CATEGORY"></i> Item Category</a></li>
                            @endif
                            @if($LA_GRP["M2000004"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/inventory/unit_measure') }}"><i class="fa fa-circle-o" id="SideBar_MFile_ITEM_UNIT"></i> Unit Measure</a></li>
                            @endif
                            @if($LA_GRP["M2000005"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/inventory/item') }}"><i class="fa fa-circle-o" id="SideBar_MFile_ITEM"></i> Items</a></li>
                            @endif
                            {{-- <li><a href="#"><i class="fa fa-circle-o"></i> Assembled Items</a></li> --}}
                            @if($LA_GRP["M2000006"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/inventory/stock_location') }}"><i class="fa fa-circle-o" id="SideBar_MFile_STOCK_LOCATION"></i> Stock Locations</a></li>
                            @endif
                            @if($LA_GRP["M2000007"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/inventory/mode_of_payment') }}"><i class="fa fa-circle-o" id="SideBar_MFile_MODE_OF_PAYMENT"></i> Mode of Payment</a></li>
                            @endif
                            @if($LA_GRP["M2000008"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/inventory/supplier') }}"><i class="fa fa-circle-o" id="SideBar_MFile_SUPPLIER"></i> Supplier</a></li>
                            @endif
                            @if($LA_GRP["M2000009"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/inventory/cost-center') }}"><i class="fa fa-circle-o" id="SideBar_MFile_COST_CENTER"></i> Cost Centers</a></li>
                            @endif
                            @if($LA_GRP["M2000010"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/inventory/sub-cost-center') }}"><i class="fa fa-circle-o" id="SideBar_MFile_SUB_COST_CENTER"></i> Sub Cost Centers</a></li>
                            @endif
                            @if($LA_GRP["M2000011"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/inventory/vat') }}"><i class="fa fa-circle-o" id="SideBar_MFile_VAT"></i> Vat Codes</a></li>
                            @endif
                            {{-- <li><a href="#"><i class="fa fa-circle-o"></i> Print Bar Code</a></li>
                            <li><a href="#"><i class="fa fa-circle-o"></i> Print Bar Code 2</a></li> --}}
                        </ul>
                    </li>
                    {{-- <li class="treeview" id="TreeView_MasterFile_Collection">
                        <a href="#">
                            <i class="fa fa-circle-o" id="SideBar_MFile_Collection"></i>
                            <span>Collection</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                              <!-- <span class="label label-primary pull-right">4</span> -->
                            </span>
                        </a>
                        <ul class="treeview-menu" style="white-space: normal;" id="TreeView_MasterFile_Collection2">
                        </ul>
                    </li> --}}
                    @endif
                    @if($LA_GRP["M2000000"]["restrict"] == 'Y')
                    <li class="treeview" id="TreeView_MasterFile_Others">
                        <a href="#">
                            <i class="fa fa-circle-o" id="SideBar_MFile_Inventory"></i>
                            <span>Miscellaneous</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                              <!-- <span class="label label-primary pull-right">4</span> -->
                            </span>
                        </a>
                        <ul class="treeview-menu" style="white-space: normal;" id="TreeView_MasterFile_Others2">
                            @if($LA_GRP["M2000001"]["restrict"] == 'Y')
                            <li><a href="{{ url('master-file/Miscellaneous/bank') }}"><i class="fa fa-circle-o" id="SideBar_MFile_BRAND_NAME"></i> Banks</a></li>
                            {{-- <li><a href="{{ url('master-file/Miscellaneous/Barangay') }}"><i class="fa fa-circle-o" id="SideBar_MFile_BARANGAY"></i> Barangay</a></li> --}}
                            <li><a href="{{ url('master-file/general/barangay') }}"><i class="fa fa-circle-o" id="SideBar_MFile_GEN_BAR"></i> Barangay</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    {{-- <li class="treeview" id="TreeView_MasterFile_General_Menu">
                        <a href="#">
                            <i class="fa fa-circle-o" id="SideBar_MFile_General"></i>
                            <span>General</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" style="white-space: normal;" id="TreeView_MasterFile_General_Menu2">
                            <li><a href="{{ url('master-file/general/barangay') }}"><i class="fa fa-circle-o" id="SideBar_MFile_GEN_BAR"></i> Barangay</a></li>
                        </ul>
                    </li> --}}
                </ul>
            </li>
            @endif
            {{-- @if($LA_GRP["A0000000"]["restrict"] == 'Y') --}}
            {{-- <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Accounting</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                      <!-- <span class="label label-primary pull-right">4</span> -->
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if($LA_GRP["A1000000"]["restrict"] == 'Y')
                    <li><a href="#"><i class="fa fa-circle-o"></i> Statement of Account</a></li>
                    @endif
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Collection Entry</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                              <span class="label label-primary pull-right">4</span>
                            </span>
                        </a>
                        <ul class="treeview-menu" style="white-space: normal;">
                            <li><a href=""><i class="fa fa-circle-o"></i> Issuance of OR</a></li>
                            <li><a href=""><i class="fa fa-circle-o"></i> Collection Entry/Important thru iTax</a></li>
                            <li><a href=""><i class="fa fa-circle-o"></i> Posting</a></li>
                            <li><a href=""><i class="fa fa-circle-o"></i> Verification of Liquidating Office</a></li>
                            <li><a href=""><i class="fa fa-circle-o"></i> Bank deposit</a></li>
                        </ul>
                    </li>
                    <li><a href=""><i class="fa fa-circle-o"></i> Disburement Entry</a></li>
                    @if($LA_GRP["A2000000"]["restrict"] == 'Y')
                    <li><a href="#"><i class="fa fa-circle-o"></i> Budget Entry</a></li>
                    @endif
                    @if($LA_GRP["A3000000"]["restrict"] == 'Y')
                    <li><a href="#"><i class="fa fa-circle-o"></i> Release Check</a></li>
                    @endif
                    @if($LA_GRP["A4000000"]["restrict"] == 'Y')
                    <li><a href="#"><i class="fa fa-circle-o"></i> Post to Ledger</a></li>
                    @endif
                    @if($LA_GRP["A5000000"]["restrict"] == 'Y')
                    <li><a href="#"><i class="fa fa-circle-o"></i> Journalize Collection Entry</a></li>
                    @endif
                    @if($LA_GRP["A6000000"]["restrict"] == 'Y')
                    <li><a href="#"><i class="fa fa-circle-o"></i> Journalize Disbursement Entry</a></li>
                    @endif
                </ul>
            </li> --}}
            {{-- @endif --}}
            <!-- <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li> -->
            @if($LA_GRP["B0000000"]["restrict"] == 'Y')
            <li class="treeview" id="SideBar_Budget">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Budget</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview" id="TreeView_MasterFile_Inventory_Menu">
                        <a href="#">
                            <i class="fa fa-files-o" id="SideBar_MFile_Inventory"></i>
                            <span>Local Budget Preparations</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                              <!-- <span class="label label-primary pull-right">4</span> -->
                            </span>
                        </a>
                        <ul class="treeview-menu" style="white-space: normal;" id="TreeView_Budget_LBP">
                            <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 1</a></li>
                            <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 2</a></li>
                            <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 3</a></li>
                            <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 4</a></li>
                            <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 5</a></li>
                            <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 6</a></li>
                            <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 7</a></li>
                            <li><a href="{{ url('budget/lbp/8') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 8</a></li>
                            <li><a href="{{ url('budget/lbp/9') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 9</a></li>
                        </ul>
                    </li>
                    @if($LA_GRP["B1000000"]["restrict"] == 'Y')
                    <li><a href="{{ url('budget/budget-proposal-entry-new') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Proposal_Entry_New"></i> Budget Proposal Entry</a></li>
                    @endif
                    @if($LA_GRP["B2000000"]["restrict"] == 'Y')
                    <li><a href="{{ url('budget/budget-proposal-entry') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Proposal_Entry"></i> Budget Appropriation</a></li>
                    @endif
                    {{-- @if($LA_GRP["B3000000"]["restrict"] == 'Y')
                    <li><a href="{{ url('budget/budget-approved-entry') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> Budget Allotment</a></li>
                    @endif --}}
                    <li><a href="{{ route('budget.allotment') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> Budget Allotment</a></li>
                    {{-- <li><a href="{{ url('budget/budget-obligation-entry') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Obligation_Entry"></i> Budget Obligation</a></li> --}}
                    @if($LA_GRP["B4000000"]["restrict"] == 'Y')
                   {{--  <li><a href="{{ asset('accounting/collection/obligation_request') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Obligation_Entry"></i> Budget Obligation</a></li> --}}
                    <li><a href="{{ asset('/accounting/collection/obligation_request/Entry/Admin/') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Obligation_Entry"></i> Budget Obligation</a></li>
                    @endif
                    <!--             <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
            <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
            <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li> -->
                </ul>
            </li>
            @endif
            @if($LA_GRP["C0000000"]["restrict"] == 'Y')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>City Treasure</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" id="collection">
                    @if($LA_GRP["C1000000"]["restrict"] == 'Y')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-files-o"></i>
                            <span>Collection Entry</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                              <!-- <span class="label label-primary pull-right">4</span> -->
                            </span>
                        </a>
                        <ul class="treeview-menu" style="white-space: normal;" id="collection_menu">
                            @if($LA_GRP["C1000001"]["restrict"] == 'Y')
                            <li><a href="{{ asset('accounting/collection/import') }}"><i class="fa fa-circle-o"></i> Import iTax</a></li>
                            @endif
                            @if($LA_GRP["C1000002"]["restrict"] == 'Y')
                            <li><a href="{{ url('accounting/collection/entry') }}"><i class="fa fa-circle-o"></i> Collection Entry/Imported iTax</a></li>
                            @endif
                            @if($LA_GRP["C1000001"]["restrict"] == 'Y')
                            <li><a href="{{ asset('accounting/collection/or_issuance') }}"><i class="fa fa-circle-o"></i> Issuance of OR</a></li>
                            @endif
                           {{--  @if($LA_GRP["C1000003"]["restrict"] == 'Y')
                            <li><a href="#"><i class="fa fa-circle-o"></i> Posting</a></li>
                            @endif --}}
                            @if($LA_GRP["C1000003"]["restrict"] == 'Y')
                            <li><a href="{{ url('collection/ROCAD/') }}"><i class="fa fa-circle-o"></i> ROCAD/Posting</a></li>
                            @endif
                            @if($LA_GRP["C1000004"]["restrict"] == 'Y')
                            <li><a href="{{ url('collection/Liquidating-officer/') }}"><i class="fa fa-circle-o"></i> Verification of Liquidating Office</a></li>
                            @endif
                            @if($LA_GRP["C1000005"]["restrict"] == 'Y')
                            <li><a href="{{ url('collection/Bank-Deposit/') }}"><i class="fa fa-circle-o"></i> Bank deposit</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if($LA_GRP["C2000000"]["restrict"] == 'Y')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-files-o"></i>
                            <span>Disbursement Entry</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                              <!-- <span class="label label-primary pull-right">4</span> -->
                            </span>
                        </a>
                        <ul class="treeview-menu" style="white-space: normal;">
                            @if($LA_GRP["C2000001"]["restrict"] == 'Y')
                            <li><a href="{{asset('accounting/disbursement')}}"><i class="fa fa-circle-o"></i> Disbursement Entry</a></li>
                            @endif
                            @if($LA_GRP["C2000002"]["restrict"] == 'Y')
                            <li><a href="{{ asset('accounting/disbursement/check_issuance') }}"><i class="fa fa-circle-o"></i> Check Issuance</a></li>
                            @endif
                            @if($LA_GRP["C2000003"]["restrict"] == 'Y')
                            <li><a href="{{ asset('accounting/disbursement/check_release') }}"><i class="fa fa-circle-o"></i> Check Release</a></li>
                            @endif
                            @if($LA_GRP["C2000004"]["restrict"] == 'Y')
                            <li><a href=""><i class="fa fa-circle-o"></i> Employee Claim</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if($LA_GRP["I0000000"]["restrict"] == 'Y')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit" id="SideBar_Inv_Acq"></i> <span>Inventory</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu" style="white-space: normal;">
                    <!-- <li><a href=""><i class="fa fa-circle-o"></i> Purchase Request</a></li>
                    <li><a href=""><i class="fa fa-circle-o"></i> Purchase Orders</a></li> -->
                    <li><a href="{{route('inventory.stockin')}}"><i class="fa fa-circle-o"></i>Stock In</a></li> 
                    <hr>
                    <li><a href="{{route('inventory.ris')}}"><i class="fa fa-circle-o"></i>Requisition Issuance Slip</a></li>
                    <li><a href="{{route('inventory.stockrelease')}}"><i class="fa fa-circle-o"></i>Stock Release</a></li>
                    <li><a href="{{route('inventory.ics')}}"><i class="fa fa-circle-o"></i>Inventory Custodian Slip</a></li>
                    <hr>
                    <li><a href="{{route('inventory.are')}}"><i class="fa fa-circle-o"></i>Acknowledgement Receipt Equipment</a></li>
                    <hr>
                    <li><a href="{{route('inventory.wastematerial')}}"><i class="fa fa-circle-o"></i>Waste Material</a></li>
                    <!-- <hr>
                    <li><a href="{{route('inventory.rpo')}}"><i class="fa fa-circle-o"></i> Acknowledgement Receipt Equipment</a></li>
                    <li><a href=""><i class="fa fa-circle-o"></i> Direct Purchases</a></li>
                    <li><a href="{{route('inventory.pr')}}"><i class="fa fa-circle-o"></i> Purchase Returns</a></li> -->
                    <hr>
                    <!-- <li><a href="{{route('inventory.stockissuance')}}"><i class="fa fa-circle-o"></i> Stock Issuance</a></li> -->
                    <!-- <li><a href="{{route('inventory.stocktransfer')}}"><i class="fa fa-circle-o"></i> Stock Transfer</a></li>
                    <li><a href="{{route('inventory.recvstocktransfer')}}"><i class="fa fa-circle-o"></i> Receiving Stock Transfer</a></li> -->
                    @if($LA_GRP["I6000000"]["restrict"] == 'Y')
                    <li><a href="{{route('inventory.stockadjustment')}}"><i class="fa fa-circle-o"></i> Stock Adjustment</a></li>
                    @endif
                    @if($LA_GRP["I7000000"]["restrict"] == 'Y')
                    <li><a href="{{route('inventory.stocktransactcard')}}"><i class="fa fa-circle-o"></i> Stock Transaction Card</a></li>
                    @endif
                    <hr>
                    <li><a href="{{route('inventory.itemsearch')}}"><i class="fa fa-circle-o"></i>Item Search</a></li>
                    <!-- <li><a href=""><i class="fa fa-circle-o"></i> Journalize Stock Transactions</a></li>
                    <li><a href=""><i class="fa fa-circle-o"></i> Journalize Purchases Transactions</a></li> -->
                    <hr>
                    @if($LA_GRP["I4000000"]["restrict"] == 'Y')
                    <li><a href="{{route('inventory.itemrepair')}}"><i class="fa fa-circle-o"></i>Item Repair</a></li>
                    @endif
                    @if($LA_GRP["I4000000"]["restrict"] == 'Y')
                    <li><a href="{{route('inventory.turnover')}}"><i class="fa fa-circle-o"></i>Turn Over</a></li>
                    @endif
                    <hr>
                    
                    <li class="treeview">
                        {{-- <a href="{{ url('reports/budget/lbp') }}"><i class="fa fa-circle-o"></i> LBP</a> --}}
                        <a href="#">
                            <i class="fa fa-circle-o"></i> 
                            <span>Biology</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" style="white-space: normal;" id="Biological_Inv">
                            @if($LA_GRP["I4000000"]["restrict"] == 'Y')
                            <li><a href="{{route('inventory.biology.bio_acq_table')}}"><i class="fa fa-circle-o" id="SideBar_Inv_Acq"></i>Biology Acqusition</a></li>
                            @endif
                            @if($LA_GRP["I4000000"]["restrict"] == 'Y')
                            <li><a href="{{route('inventory.biology.bio_boo_table')}}"><i class="fa fa-circle-o"></i>Biology Birth of Offspring</a></li>
                            @endif
                            @if($LA_GRP["I4000000"]["restrict"] == 'Y')
                            <li><a href="{{route('inventory.biology.bio_dispo_table')}}"><i class="fa fa-circle-o"></i>Biology Disposition</a></li>
                            @endif
                        </ul>
                    </li>
                   

                    <hr>
                </ul>
            </li>
            @endif
            @if($LA_GRP["R0000000"]["restrict"] == 'Y')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-table"></i> 
                        <span>Reports</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    @if($LA_GRP["R1000000"]["restrict"] == 'Y')
                    <li><a href="#"><i class="fa fa-circle-o"></i> Accounting</a></li>
                    @endif
                    @if($LA_GRP["R2000000"]["restrict"] == 'Y')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Budget</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            <ul class="treeview-menu">
                                {{-- @if($LA_GRP["R2000001"]["restrict"] == 'Y') --}}
                                {{-- <li><a href="{{ url('report/budget/saaob') }}"><i class="fa fa-circle-o"></i> SAAOB</a></li> --}}
                                <li><a href="{{ route('report.saaob') }}"><i class="fa fa-circle-o"></i>SAAOB</a></li>
                                <li><a href="{{ url('reports/budget/rao/') }}"><i class="fa fa-circle-o"></i> RAO Report</a></li>
                                {{-- @endif --}}

                                <li class="treeview">
                                    {{-- <a href="{{ url('reports/budget/lbp') }}"><i class="fa fa-circle-o"></i> LBP</a> --}}
                                    <a href="#">
                                        <i class="fa-circle-o"></i> 
                                        <span>LBP Reports</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu" style="white-space: normal;" id="TreeView_Budget_LBP">
                                        <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 1</a></li>
                                        <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 2</a></li>
                                        <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 3</a></li>
                                        <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 4</a></li>
                                        <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 5</a></li>
                                        <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 6</a></li>
                                        <li><a href="{{ url('') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 7</a></li>
                                        <li><a href="{{ url('reports/budget/lbp/8') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 8</a></li>
                                        <li><a href="{{ url('reports/budget/lbp/9') }}"><i class="fa fa-circle-o" id="SideBar_Budget_Budget_Approved_Entry"></i> LBP No. 9</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </a>
                    </li>
                    @endif
                    @if($LA_GRP["R2000000"]["restrict"] == 'Y')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Collection</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            <ul class="treeview-menu">
                                <li><a href="{{ url('reports/collection/RocadDailyUser') }}"><i class="fa fa-circle-o"></i>ROCAD</a></li>
                                <li><a href="{{ url('reports/collection/abstract') }}"><i class="fa fa-circle-o"></i>ABSTRACT Report</a></li>
                                <li><a href="{{ url('reports/collection/Daily-Collection') }}"><i class="fa fa-circle-o"></i>Daily Collections</a></li>

                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-circle-o"></i>
                                        <span>Real Property</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                        <ul class="treeview-menu">
                                            <li><a href="{{ url('reports/collection/Real-Property-Tax') }}"><i class="fa fa-circle-o"></i>Daily</a></li>
                                        </ul>
                                    </a>
                                </li>

                                <li><a href="{{ url('reports/collection/Statement-Of-Collection') }}"><i class="fa fa-circle-o"></i>Statement of Collections</a></li>

                            </ul>
                        </a>
                    </li>
                    @endif
                    @if($LA_GRP["R3000000"]["restrict"] == 'Y')
                    <li><a href="#"><i class="fa fa-circle-o"></i> Sales</a></li>
                    @endif
                    @if($LA_GRP["R4000000"]["restrict"] == 'Y')
                     <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Inventory</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            <ul class="treeview-menu">
                                {{-- @if($LA_GRP["R2000001"]["restrict"] == 'Y') --}}
                                {{-- <li><a href="{{ url('report/budget/saaob') }}"><i class="fa fa-circle-o"></i> SAAOB</a></li> --}}
                                <li><a href="{{ route('inventory.bioreportsview') }}"><i class="fa fa-circle-o"></i>Biology</a></li>
                                {{-- @endif --}}
                            </ul>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            <!--  <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li> -->
            @if($LA_GRP["S0000000"]["restrict"] == 'Y')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Settings</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if($LA_GRP["S1000000"]["restrict"] == 'Y')
                    <li><a href="{{ url('settings/group-rights') }}"><i class="fa fa-circle-o"></i> Group Rights Settings</a></li>
                    @endif
                    @if($LA_GRP["S2000000"]["restrict"] == 'Y')
                    <li><a href="{{ url('settings/users') }}"><i class="fa fa-circle-o"></i> User Settings</a></li>
                    @endif
                    {{-- <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Notification Settings</a></li>
                    <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> System Data Update</a></li> --}}
                </ul>
            </li>
            @endif
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Help</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> About</a></li>
                </ul>
            </li>
            <!-- <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li> -->
            <!-- <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>