# Medical Serve
** Restful API for patients to:** 
- reserve an appointment with doctors 
- labs for lab samples 
- search for nurses
#### Endpoints　

```javascript
 POST     | /api/user-auth/signup 
 POST     | /api/user-auth/login  
 POST     | /api/user-auth/recovery
 POST     | /api/user-auth/reset
 POST     | /api/user-auth/logout
 POST     | /api/user-auth/refresh
 GET|HEAD | /api/user-auth/me
 GET|HEAD | /api/user-auth/social/redirect/{provider}
 GET|HEAD | /api/user-auth/social/login/{provider}
 POST     | /api/hospitalization-auth/signup
 POST     | /api/hospitalization-auth/login
 POST     | /api/hospitalization-auth/recovery
 POST     | /api/hospitalization-auth/reset
 POST     | /api/hospitalization-auth/refresh
 POST     | /api/hospitalization-auth/logout
 GET|HEAD | /api/hospitalization-auth/me
 POST     | /api/dr/create-profile
 POST     | /api/dr/edit-profile/{slug}
 POST     | /api/lab/create-profile
 POST     | /api/lab/edit-profile/{slug}
 POST     | /api/hospital/create-profile
 POST     | /api/hospital/edit-profile/{slug}
 GET|HEAD | /api/protected
 GET|HEAD | /api/refresh
 GET|HEAD | /api/hello

```