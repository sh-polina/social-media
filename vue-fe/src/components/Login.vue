<script setup>
import {ref} from "vue";
import useAuthStore from "../stores/auth";

const authStore = useAuthStore();

const form = ref({
  email: '',
  password: ''
});




</script>

<template>
  <section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <h3 class="mb-5">Login</h3>
              <form v-on:submit.prevent="authStore.handleLogin(form)">
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="email" v-model="form.email" id="typeEmailX-2" class="form-control form-control-lg"/>
                  <label class="form-label" for="typeEmailX-2">Email</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" v-model="form.password" id="typePasswordX-2"
                         class="form-control form-control-lg"/>
                  <label class="form-label" for="typePasswordX-2">Password</label>
                </div>

                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block"
                        type="submit">Login
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>