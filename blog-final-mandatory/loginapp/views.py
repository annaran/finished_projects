from django.shortcuts import render, redirect
from django.urls import reverse
from django.http import HttpResponseRedirect
from django.contrib.auth.models import User
from django.contrib.auth import authenticate, login as dj_login, logout as dj_logout
from django.contrib import messages
from .forms import UserSignupForm
from django.contrib.auth.decorators import login_required


def login(request):
    context = {}
    if request.method == 'POST':
        user = authenticate(request, 
            username=request.POST['user'], 
            password=request.POST['password'])
        if user:
            dj_login(request, user)
            context = {'user':request.POST['user']}
            return HttpResponseRedirect(reverse('loginapp:profile'))
        else:
            context = {'error':'Username or password is wrong.'}

    return render(request, 'loginapp/login.html', context)

def logout(request):
    dj_logout(request)
    return HttpResponseRedirect(reverse('loginapp:login'))

@login_required
def profile(request):    
    return render(request, 'loginapp/profile.html')

def signup(request):
    if request.method == 'POST':
        form = UserSignupForm(request.POST)
        if form.is_valid():
            form.save()
            username = form.cleaned_data.get('username')
            messages.success(request, f'Account created for { username }!')
            return HttpResponseRedirect(reverse('loginapp:login'))
    else:
        form = UserSignupForm()
    return render(request,'loginapp/signup.html', {'form':form})


def password_reset(request):
    context = {}
    if request.method == 'POST':
        users = User.objects.filter(username=request.POST['user'])
        if users:
            user = users[0]
            new_password = random_string()
            #new_password = '1111'
            user.set_password(new_password)
            user.save()
            print(f'**** User {user} changed password to {new_password}')
            return HttpResponseRedirect(reverse('loginapp:password_reset_confirmation'))
        else:
            context['error'] = 'No such username.'
        
    return render(request, 'loginapp/password_reset.html', context)

def password_reset_confirmation(request):    
    return render(request, 'loginapp/password_reset_confirmation.html')