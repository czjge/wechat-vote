<aside class="main-sidebar">
    <section class="sidebar">



        <ul class="sidebar-menu">
            <li class="header">菜单</li>

            <li class="treeview">
                <a href="{{ route('admin.vote.list') }}">
                    <i class="fa fa-dashboard"></i> <span>投票管理</span>
                    {{--<span class="pull-right-container">--}}
                    {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                </a>
                {{--<ul class="treeview-menu">--}}
                {{--<li><a href="{{ route('admin.vote.list') }}"><i class="fa fa-circle-o"></i>投票列表</a></li>--}}
                {{--</ul>--}}
            </li>

            @adminrole('admin')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>人员管理</span>
                    <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.admin.list') }}" onclick='highLightMenu(this.parentNode);'><i class="fa fa-circle-o"></i> <span>用户列表</span></a></li>
                    <li><a href="{{ route('admin.role.list') }}" onclick='highLightMenu(this.parentNode);'><i class="fa fa-circle-o"></i> <span>角色列表</span></a></li>
                    <li><a href="{{ route('admin.permission.list') }}" onclick='highLightMenu(this.parentNode);'><i class="fa fa-circle-o"></i> <span>权限列表</span></a></li>
                </ul>
            </li>
            @endadminrole

            {{--<li class="treeview">--}}
            {{--<a href="{{ route('admin.hospital.list') }}">--}}
            {{--<i class="fa fa-hospital-o"></i> <span>好医生-医院管理</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="treeview">--}}
            {{--<a href="{{ route('admin.department.list') }}">--}}
            {{--<i class="fa fa-h-square"></i> <span>好医生-科室管理</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="treeview">--}}
            {{--<a href="{{ route('admin.doctor.list') }}">--}}
            {{--<i class="fa fa-user-md"></i> <span>好医生-医生管理</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="treeview">--}}
            {{--<a href="{{ route('admin.familydoctor.community.list') }}">--}}
            {{--<i class="fa fa-home"></i> <span>家庭医生-社区管理</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="treeview">--}}
            {{--<a href="{{ route('admin.familydoctor.team.list') }}">--}}
            {{--<i class="fa fa-h-square"></i> <span>家庭医生-团队管理</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="treeview">--}}
            {{--<a href="{{ route('admin.familydoctor.doctor.list') }}">--}}
            {{--<i class="fa fa-user"></i> <span>家庭医生-医生管理</span>--}}
            {{--</a>--}}
            {{--</li>--}}

        </ul>




    </section>
</aside>