<script>
import { API } from "@/configs/API.js";
export default {
  data: () => ({
    userWeather: null,
    isLoading: false,
    error: "",
  }),

  created() {
    this.fetchData();
  },

  methods: {
    async fetchData() {
      try {
        this.error = "";
        this.isLoading = true;
        const response = await (
          await fetch(`${API}/${this.$route.params.id}`)
        ).json();
        this.userWeather = response.data;
      } catch (error) {
        this.error = error.response.data.message;
      }
      this.isLoading = false;
    },
  },
};
</script>

<template>
  <div>
    <div v-if="error" class="card-body">{{ error }}</div>
    <div v-if="isLoading">Loading...</div>
    <div v-else class="card">
      <div class="card-header">{{ userWeather.name }}</div>
      <div class="card-body">
        <h5 class="card-title">
          Temperature:
          {{ userWeather?.weather?.current_weather?.temperature }} F
          <span class="float-right"
            >Time: {{ userWeather?.weather?.current_weather?.time }}</span
          >
        </h5>
        <p class="card-text">
          Additional Forecast details from
          <a
            href="https://api.open-meteo.com/"
            target="_blank"
            rel="open-metro"
          >
            https://api.open-meteo.com/
          </a>
        </p>

        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            windspeed:
            <span class="float-right">{{
              userWeather?.weather?.current_weather?.windspeed
            }}</span>
          </li>

          <li class="list-group-item">
            winddirection:
            <span class="float-right">{{
              userWeather?.weather?.current_weather?.winddirection
            }}</span>
          </li>

          <li class="list-group-item">
            TimeZone:
            <span class="float-right">{{
              userWeather?.weather?.timezone
            }}</span>
          </li>

          <li class="list-group-item">
            elevation:
            <span class="float-right">{{
              userWeather?.weather?.elevation
            }}</span>
          </li>
        </ul>

        <router-link class="btn btn-primary" to="/">Back</router-link>
      </div>
    </div>
  </div>
</template>
