## Tech Stack

* **Frontend:** Plain PHP with Bootstrap
* **Backend:** Django (Django REST Framework)
* **Database:** SQLite (for simplicity - can be replaced with PostgreSQL or MySQL)

## Features

* List all registered users.
* View detailed information for each user.

## Setup Instructions


  **Configure Settings (`myproject/settings.py`):**

    * Add `'rest_framework'` and `'api'` to `INSTALLED_APPS`:

        ```python
        INSTALLED_APPS = [
            # ... other apps
            'rest_framework',
            'api',
        ]
        ```

  **Create Serializers (`api/serializers.py`):**

    ```python
    from django.contrib.auth.models import User
    from rest_framework import serializers

    class UserSerializer(serializers.ModelSerializer):
        class Meta:
            model = User
            fields = ('id', 'username', 'email', 'first_name', 'last_name')
    ```

  **Create Views (`api/views.py`):**

    ```python
    from django.contrib.auth.models import User
    from rest_framework import generics
    from .serializers import UserSerializer

    class UserList(generics.ListAPIView):
        queryset = User.objects.all()
        serializer_class = UserSerializer

    class UserDetail(generics.RetrieveAPIView):
        queryset = User.objects.all()
        serializer_class = UserSerializer
    ```

  **Create URLs (`api/urls.py`):**

    ```python
    from django.urls import path
    from . import views

    urlpatterns = [
        path('users/', views.UserList.as_view()),
        path('users/<int:pk>/', views.UserDetail.as_view()),
    ]
    ```

  **Include `api/urls.py` in `myproject/urls.py`:**

    ```python
    from django.contrib import admin
    from django.urls import path, include

    urlpatterns = [
        path('admin/', admin.site.urls),
        path('api/', include('api.urls')),
    ]
    ```

  **Run Migrations:**

    ```bash
    python manage.py makemigrations
    python manage.py migrate
    ```

 **Create a Superuser:**

    ```bash
    python manage.py createsuperuser
    ```

 **Run the Development Server:**

    ```bash
    python manage.py runserver
    ```

### Frontend Setup (PHP)


  **Create `index.php`:**

    * Place the provided `index.php` code inside the `myfrontend` folder.

  **Access the Frontend:**

    * Open your web browser and navigate to `http://localhost/myfrontend/index.php`.

## Code Working Explanation

### Backend (Django REST Framework)

* **Models:** We use Django's built-in `User` model to manage user data.
* **Serializers:** The `UserSerializer` converts `User` model instances to JSON and vice-versa. This is essential for the API.
* **Views:**
    * `UserList` (a `ListAPIView`) retrieves all `User` objects and serializes them into a JSON list.
    * `UserDetail` (a `RetrieveAPIView`) retrieves a specific `User` object based on the primary key (`pk`) and serializes it into JSON.
* **URLs:** The URLs map API endpoints to their respective views. For example, `/api/users/` is mapped to `UserList`, and `/api/users/<pk>/` is mapped to `UserDetail`.
* **Migrations:** Django's migrations ensure that the database schema is in sync with the models.

### Frontend (PHP)

* **HTML Structure:** The `index.php` file contains the basic HTML structure with Bootstrap for styling.
* **JavaScript:**
    * The JavaScript code uses the `fetch` API to make requests to the Django backend API endpoints.
    * `fetchUsers()` function retrieves all users from `/api/users/` and dynamically populates a table with the data.
    * `fetchUserDetails(userId)` function retrieves details for a specific user from `/api/users/<userId>/` and displays them in a modal.
    * jQuery is used for DOM manipulation and event handling.
* **Bootstrap:** Bootstrap provides CSS styling and components like modals to enhance the user interface.

### Workflow

1.  The user accesses `index.php` in the browser.
2.  The JavaScript code in `index.php` sends a GET request to the Django API (`/api/users/`).
3.  The Django backend's `UserList` view retrieves the user data from the database and returns it as JSON.
4.  The JavaScript code receives the JSON data and populates the HTML table.
5.  When the user clicks "View Details," the `fetchUserDetails()` function sends a GET request to `/api/users/<userId>/`.
6.  The Django backend's `UserDetail` view retrieves the specific user's data and returns it as JSON.
7.  The JavaScript code receives the JSON data and displays it in a modal.
