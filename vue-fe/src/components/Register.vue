<script setup>
import {ref} from "vue";
import useAuthStore from "../stores/auth";

const authStore = useAuthStore();
const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})


</script>

<template>
  <section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <h3 class="mb-5">Register</h3>
              <form @submit.prevent="authStore.handleRegister(form)">
                <div data-mdb-input-init class="form-outline mb-4">
                  <input v-model="form.name" type="text" id="typeEmailX-2" class="form-control form-control-lg"/>
                  <label class="form-label" for="typeEmailX-2">Name</label>
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                  <input v-model="form.email" type="email" id="typeEmailX-2" class="form-control form-control-lg"/>
                  <label class="form-label" for="typeEmailX-2">Email</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input v-model="form.password" type="password" id="typePasswordX-2"
                         class="form-control form-control-lg"/>
                  <label class="form-label" for="typePasswordX-2">Password</label>
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                  <input v-model="form.password_confirmation" type="password" id="typePasswordX-2"
                         class="form-control form-control-lg"/>
                  <label class="form-label" for="typePasswordX-2">Password confirmation</label>
                </div>

                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block"
                        type="submit">Register
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>