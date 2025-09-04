<?php

function has_role($roleName)
{
    $CI = &get_instance();
    $userRole = $CI->session->userdata('role');
    return $userRole == $roleName;
}

function has_permission($permissionName)
{
    $CI = &get_instance();
    $userPermissions = $CI->session->userdata('permissions');
    return has_role('admin') || in_array($permissionName, $userPermissions);
}
