<template>    
    <div class="mx-auto container p-2 lg:p-8 flex flex-col">
      <h1>Employee details</h1>
        <div v-if="button=='Submit'" class="grid grid-cols-1 gap-6 bg-gray-100 dark:bg-gray-900 rounded p-8 w-full sm:grid-cols-2 lg:grid-cols-3">
          <form @submit.prevent="submitForm">
            <div class="mb-3 row">
              <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="form.name">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="form.email">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Exprience</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="form.exprience">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Skil</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="form.skil">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Interests</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="form.interests">
              </div>
            </div>
            <div class="col-md-5 col-lg-4 col-6">
              <div class="">
                <button type="submit" class="bg-blue-500 w-20 h-10">{{button}}</button>
              </div>
            </div>
          </form>
        </div>
        <div v-else class="grid grid-cols-1 gap-6 bg-gray-100 dark:bg-gray-900 rounded p-8 w-full sm:grid-cols-2 lg:grid-cols-3">
          <form @submit.prevent="updateEmployee">
            <div class="mb-3 row">
              <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="form.name">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="form.email">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Exprience</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="form.exprience">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Skil</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="form.skil">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Interests</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="form.interests">
              </div>
            </div>
            <div class="col-md-5 col-lg-4 col-6">
              <!--<div class="divide-y divide-blue-200 ring-offset-2 ring-2">-->
              <div class="">
                <button type="submit" class="bg-green-500 w-20 h-10">{{button}}</button>
              </div>
            </div>
          </form>
        </div>
        <div>
          <div class="divide-y divide-blue-200 ring-offset-2 ring-2">
           <div></div>
            <table class="border-separate border border-slate-400 ...">
              <thead>
                <tr>
                  <th class="border">Name</th>
                  <th class="border">Email</th>
                  <th class="border">Exprience</th>
                  <th class="border">Skil</th>
                  <th class="border">Interests</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="employee in employees.data" :key="employee.id">
                  <td class="border">{{ employee.name }}</td>
                  <td class="border">{{employee.email}}</td>
                  <td class="border">{{employee.exprience}}</td>
                  <td class="border">{{employee.skil}}</td>
                  <td class="border">{{employee.interests}}</td>
                  <td class="border">
                    <button @click="editEmployee(employee)" class="bg-emerald-900 text-white rounded">Edit</button>
                    <button @click="deleteEmployee(employee.id)" class="bg-orange-400 rounded">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default{

  data(){
    return {
      form:{
        name: '',
        email: '',
        exprience: '',
        skil: '',
        interests: '',
      },
      button: 'Submit',
      msg: '',
      employee_id: '',
      employees: []
    }
  },
  methods: {
      async submitForm(){
        this.msg = await axios.post('http://localhost:8000/api/user',{content:this.form});
        console.log(this.msg);
        this.formReset();
        this.fetch();
      },
      async getEmployee(){
				let res = await axios.get('http://localhost:8000/api/user');
        console.log(res);
			},
      async fetch(){
        this.employees = await fetch('http://localhost:8000/api/user').then(res=>res.json())
        console.log(this.employees)
      },
      async formReset(){
				this.form.name = '';
				this.form.email = '';
				this.form.exprience = '';
				this.form.skil = '';
				this.form.interests = '';
			},
      async deleteEmployee(id){
        if(confirm('Are you sure want to delete?')){
            await axios.delete('http://localhost:8000/api/user/'+ id);            
        }
        this.fetch();
      },
      async editEmployee(employee){
        this.button = 'Update',
        this.employee_id = employee.id,
        this.form.name = employee.name,
        this.form.email = employee.email,
        this.form.exprience = employee.exprience,
        this.form.skil = employee.skil,
        this.form.interests = employee.interests,
        console.log(this.form);
      },
      async updateEmployee(){
        await axios.patch('http://localhost:8000/api/user/'+ this.employee_id,{content:this.form});
        this.fetch();
        this.formReset();
        this.button = 'Submit';
      }
    },
    created: function() {
      //console.log('created')
      this.fetch()
      //await axios.get('http://localhost:8000/api/user');
    },
  //async fetch() {
  //  console.log('get data');
  //  this.employees = await this.$http.$get('https://api.nuxtjs.dev/posts');
  //  console.log(this.employees);
  //}
  
}
</script>