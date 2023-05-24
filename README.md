### Assignment

Find users by `is_active`, `is_member`, `last_login_at` (range), `user_type` (multiple values)

`GET /api/users` with query parameters:
* isActive *Optional* `tinyint`
* isMember *Optional* `tinyint`
* userTypes[] *Optional* `integer`
* lastLoginAt[start] *Optional* `date`
* lastLoginAt[end] *Optional* `date`

Detailed api documentation can be found in `/api/doc` powered by swagger ui

Simple unit tests for denormalize service in `/tests`