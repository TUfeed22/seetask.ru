<?php
use Core\Route;

return [
  new Route('/admin/login-form/', 'admin', 'authorizationData'),
  new Route('/admin/login/', 'admin', 'login'),
  new Route('/admin/register/', 'admin', 'register'),
  new Route('/admin/register-form/', 'admin', 'registrationData'),
  new Route('/admin/logout/', 'admin', 'logout'),
  new Route('/admin/', 'admin', 'index'),
  new Route('/admin/user/profile/', 'user', 'index'),
  new Route('/admin/user/basic-information/', 'user', 'basicInformation'),
  new Route('/admin/projects/', 'project', 'index'),
  new Route('/admin/tasks/', 'task', 'index'),
];