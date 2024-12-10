<template>
  <div class="h-auto w-full">
    <div class="navbar bg-base-100 dark:bg-slate-950">
      <div class="flex-1">
        <a class="btn btn-ghost text-xl" @click="home">CycleLink</a>
      </div>
      <div class="flex-none">
        <a v-if="!auth" href="/login">
          <button class="btn btn-primary ml-7">Login</button>
        </a>
        <div v-if="auth" class="dropdown dropdown-end">
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
              <img :alt="user?.name || 'User avatar'" src="https://cdn.pixabay.com/photo/2020/10/07/20/53/bike-5636252_1280.png" />
            </div>
          </div>
          <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
            <li><a href="/profile" class="justify-between">Profile <span class="badge"></span></a></li>
            <li><a href="/my-rents">My Bikes</a></li>
            <li><a @click="logout">Logout</a></li>
          </ul>
        </div>-
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router'; 

export default {
  name: 'Navbar',
  setup() {
    const router = useRouter();
    const auth = ref(false);
    const user = ref(null);
    const avatarUrl = ref('https://via.placeholder.com/150');

    const validateToken = async () => {
      const token = localStorage.getItem('token');
      if (token) {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/auth', {
            headers: { Authorization: `Bearer ${token}` },
          });
          auth.value = true;
          user.value = response.data;
          avatarUrl.value = user.value.avatar || 'https://via.placeholder.com/150';
        } catch (error) {
          console.error('Token validation error:', error.response?.data || error.message);
          clearUserSession();
        }
      } else {
        clearUserSession();
      }
    };

    const clearUserSession = () => {
      localStorage.removeItem('token');
      auth.value = false;
      user.value = null;
      avatarUrl.value = 'https://via.placeholder.com/150';
    };

    const logout = async () => {
      const token = localStorage.getItem('token');
      try {
        if (token) {
          await axios.post('http://127.0.0.1:8000/api/logout', {}, {
            headers: { Authorization: `Bearer ${token}` },
          });
        }
        clearUserSession();
        window.location.reload();
      } catch (error) {
        console.error('Error during logout:', error.response?.data || error.message);
      }
    };

    const home = async () => {
      router.push({ path: "/" });
    }

    validateToken();

    return {
      auth,
      user,
      avatarUrl,
      logout,
      home,
    };
  },
};
</script>
