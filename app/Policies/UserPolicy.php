<?php

namespace App\Policies;

  use App\Models\User;
  use Illuminate\Auth\Access\HandlesAuthorization;

  class UserPolicy
  {
      use HandlesAuthorization;

      /**
       * Determine whether the user can view any models.
       *
       * @param  \App\Models\User  $user
       * @return bool
       */
      public function viewAny(User $user)
      {
          // Hanya superadmin, admin, dan subadmin yang bisa melihat daftar user.
          return in_array($user->role, ['superadmin', 'admin', 'subadmin']);
      }

      /**
       * Determine whether the user can view the model.
       *
       * @param  \App\Models\User  $user
       * @param  \App\Models\User  $model
       * @return bool
       */
      public function view(User $user, User $model)
      {
          // Superadmin bisa melihat detail user dengan role 'admin'.
          if ($user->role === 'superadmin') {
              return $model->role === 'admin';
          }

          // Admin bisa melihat detail user dengan role 'subadmin'.
          if ($user->role === 'admin') {
              return $model->role === 'subadmin';
          }

          // Subadmin bisa melihat detail user dengan role 'user'.
          if ($user->role === 'subadmin') {
              return $model->role === 'user';
          }

          return false;
      }

      /**
       * Determine whether the user can create models.
       *
       * @param  \App\Models\User  $user
       * @return bool
       */
      public function create(User $user)
      {
          // Hanya superadmin, admin, dan subadmin yang bisa membuat user baru.
          return in_array($user->role, ['superadmin', 'admin', 'subadmin']);
      }

      /**
       * Determine whether the user can update the model.
       *
       * @param  \App\Models\User  $user
       * @param  \App\Models\User  $model
       * @return bool
       */
      public function update(User $user, User $model)
      {
          // Logikanya sama dengan 'view', siapa yang bisa melihat, dia juga bisa update.
          return $this->view($user, $model);
      }

      /**
       * Determine whether the user can delete the model.
       *
       * @param  \App\Models\User  $user
       * @param  \App\Models\User  $model
       * @return bool
       */
      public function delete(User $user, User $model)
      {
          // Pengguna tidak bisa menghapus dirinya sendiri.
          if ($user->id === $model->id) {
              return false;
          }

          // Logikanya sama dengan 'view', siapa yang bisa melihat, dia juga bisa delete.
          return $this->view($user, $model);
      }
  }
