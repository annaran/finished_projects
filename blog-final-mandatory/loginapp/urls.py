from django.urls import path, include

from . import views


app_name = 'loginapp'

urlpatterns = [
    path('', views.login, name='login'),
    path('login/', views.login, name='login'),
    path('logout/', views.logout, name='logout'),
    path('signup/', views.signup, name='signup'),
    path('profile/', views.profile, name='profile'),
    path('password_reset/', views.password_reset, name='password_reset'),
    path('password_reset_confirmation/', views.password_reset_confirmation, name='password_reset_confirmation'),
    path('blog/', include('blog.urls', namespace='blog')),
]