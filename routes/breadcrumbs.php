<?php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('meyer.dashboard'));
});

// Home > Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Dashboard', route('meyer.dashboard'));
});

// Home > PA
Breadcrumbs::for('pa.timeline.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('PA Timeline History'), route('meyer.pa.timeline.index'));
});

Breadcrumbs::for('pa.follow.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Task Status Tracking'), route('meyer.pa.follow.index'));
});

Breadcrumbs::for('pa.follow.hr', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Task Status Tracking').' By HR', route('meyer.pa.follow.index'));
});

Breadcrumbs::for('formEvaluate.criteria.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Create Evaluation Criteria'), route('meyer.formEvaluate.criteria.index'));
});

Breadcrumbs::for('formEvaluate.groupForm.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Create PA Form Groups'), route('meyer.formEvaluate.groupForm.index'));
});

Breadcrumbs::for('formEvaluate.groupForm.addpage', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Create PA Form Groups'), route('meyer.formEvaluate.groupForm.index'));
});

Breadcrumbs::for('setting.uploadFile.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Upload Data'), route('meyer.setting.uploadFile.index'));
});
Breadcrumbs::for('setting.maintain.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Maintain Employee'), route('meyer.setting.maintain.index'));
});

Breadcrumbs::for('setting.uploadFile.detail2', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('History Import'), route('meyer.setting.uploadFile.index'));
});

Breadcrumbs::for('setting.uploadFile.detail3', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('History Import'), route('meyer.setting.uploadFile.index'));
});

Breadcrumbs::for('setting.manageBudget.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Set Budget'), route('meyer.setting.manageBudget.index'));
});

Breadcrumbs::for('setting.manageGrade.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Set PA Grades'), route('meyer.setting.manageGrade.index'));
});

Breadcrumbs::for('setting.manageDepartment.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Set %Increase by Dept.'), route('meyer.setting.manageDepartment.index'));
});

Breadcrumbs::for('setting.manageEmployee.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Employee Data Management'), route('meyer.setting.manageEmployee.index'));
});

Breadcrumbs::for('ListEvaluator', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Review Lists of Evaluated Employees'), route('meyer.ListEvaluator'));
});

Breadcrumbs::for('setEvaluator', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Set Evaluators and PA Forms'), route('meyer.setEvaluator'));
});

Breadcrumbs::for('evaluateReview', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Review and Approve PA Results'), route('meyer.evaluateReview'));
});



// Home > Dashboard > User Management
Breadcrumbs::for('user-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('User Management', route('meyer.user-management.users.index'));
});

// Home > Dashboard > User Management > Users
Breadcrumbs::for('user-management.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Users', route('meyer.user-management.users.index'));
});

// Home > Dashboard > User Management > Users > [User]
Breadcrumbs::for('user-management.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.users.index');
    $trail->push(ucwords($user->name), route('meyer.user-management.users.show', $user));
});

// Home > Dashboard > User Management > Roles
Breadcrumbs::for('user-management.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Roles', route('meyer.user-management.roles.index'));
});

// Home > Dashboard > User Management > Roles > [Role]
Breadcrumbs::for('user-management.roles.show', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('user-management.roles.index');
    $trail->push(ucwords($role->name), route('meyer.user-management.roles.show', $role));
});

// Home > Dashboard > User Management > Permission
Breadcrumbs::for('user-management.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Permissions', route('meyer.user-management.permissions.index'));
});

// Home > HR upload file
Breadcrumbs::for('hr_upload', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('hr_upload', route('meyer.hr_upload'));
});

Breadcrumbs::for('evaluate.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Evaluate employees'), route('meyer.evaluate'));
});

Breadcrumbs::for('paGrading.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('PA Grading'), route('meyer.paGrading'));
});

Breadcrumbs::for('salary.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Salary Increase'), route('meyer.salary'));
});

Breadcrumbs::for('approveSalary.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('Approved Salary'), route('meyer.approveSalary'));
});
