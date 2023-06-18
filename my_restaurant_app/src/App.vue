<template>
  <div>

    <header class="mb-2">
      <NavBar />
    </header>

    <router-view />

    <footer class="container mt-3">
      <FooterComponent />
    </footer>

  </div>

</template>

<script setup>
import NavBar from "@/components/NavBar";
import FooterComponent from "@/components/FooterComponent";

</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
