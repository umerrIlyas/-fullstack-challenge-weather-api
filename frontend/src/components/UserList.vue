<script>
import { API } from "@/configs/API.js";
export default {
  data: () => ({
    apiResponse: null,
    error: "",
  }),

  created() {
    this.fetchData();
  },

  methods: {
    async fetchData() {
      try {
        this.error = "";
        const url = API;
        this.apiResponse = await (await fetch(url)).json();
      } catch (error) {
        this.error = error.response.data.message;
      }
    },
  },
};
</script>

<template>
  <div v-if="!apiResponse">Pinging the api...</div>
  <div v-if="error">{{ error }}</div>

  <div v-if="apiResponse">
    <div>
      <h3>Users</h3>

      <table class="table mt-3">
        <thead class="thead-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">latitude</th>
            <th scope="col">longitude</th>
            <th scope="col">Temperature</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in apiResponse.data">
            <th scope="row">{{ index + 1 }}</th>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.latitude }}</td>
            <td>{{ user.longitude }}</td>
            <td>{{ user?.weather?.current_weather?.temperature }} F</td>
            <td>
              <router-link :to="`/${user.id}`">Go to Details</router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
