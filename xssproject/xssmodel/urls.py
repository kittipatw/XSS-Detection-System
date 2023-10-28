from django.urls import path
from . import views

urlpatterns = [
    path("", views.xssmodel, name="XSS-Model")
]