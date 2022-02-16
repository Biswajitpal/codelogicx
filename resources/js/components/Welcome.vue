<template>
    <h1 align="center">Visitors Entry System</h1>
	<div class="container p-5">
        <div class="row">
            <div class="col-sm-2">
		    <button type="button" class="btn btn-primary mb-4 float-right" data-toggle="modal" data-target="#myModal" @click="formReset">Add New Visitor</button>
            </div>
            <div class="form-group col-sm-2">
                <label> From Date</label>
                <input type="datetime-local" class="form-control" v-model="search.from_date">
            </div>
			<div class="form-group col-sm-2">
                <label> To Date</label>
                <input type="datetime-local" class="form-control" v-model="search.to_date">
            </div>
            <div class="form-group col-sm-3">
                <label>Phone No</label>
                <input type="text" class="form-control" v-model="search.phno">
            </div>
            <div class="form-group col-sm-2">
                <button class="btn btn-success" @click="searchVisitor">Search</button>
            </div>
        </div>
		<div class="modal" id="myModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-muted">Add New Visitor</h5>
						<button type="button" class="close close_modal" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="text-sm text-danger" if="errors != ''">
							<p v-for="error in errors" class="mb-0" :key="error"><small>{{ error }} </small></p>
						</div>
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control" v-model="form.first_name">
						</div>
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control" v-model="form.last_name">
						</div>
						<div class="form-group">
							<label>Phone No</label>
							<input type="email" class="form-control" v-model="form.phone_number">
						</div>
						<div class="form-group">
							<label>In Time</label>
							<input type="datetime-local" class="form-control" v-model="form.in_time">
						</div>
						<button v-if="visitor_id == ''" type="button" class="btn btn-primary" @click="storeVisitor">Submit</button>
						<button v-else type="button" class="btn btn-primary" @click="updateVisitor">Update</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal" id="exitModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-muted">Visitor Out Time</h5>
						<button type="button" class="close close_modal" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>In Time</label>
							<input type="datetime-local" class="form-control" v-model="exit.out_time">
						</div>
						<button type="button" class="btn btn-primary" @click="visitorOutTime">Send</button>
					</div>
				</div>
			</div>
		</div>

		
		<table class="table table-bordered table-hover">
			<thead>
				<th>Name</th>
				<th>Phone</th>
				<th>In Time</th>
				<th>Out Time</th>
				<th>Action</th>
			</thead>

			<tbody>
				<template v-for="visitor in visitors" :key="visitor.id">
					<tr>
						<td>{{ visitor.first_name }} {{ visitor.last_name }}</td>
						<td>{{ visitor.phone_number }}</td>
						<td>{{ visitor.in_time }}</td>
						<td>{{ visitor.out_time }}</td>
						<td>
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal" @click="editVisitor(visitor)">Edit</button>
								<button type="button" class="btn btn-sm btn-danger ml-2" @click="deleteVisitor(visitor.id)">Delete</button>
								<button type="button" class="btn btn-sm btn-warning ml-2" data-toggle="modal" data-target="#exitModal" @click="exitVisitor(visitor.id)">Exit</button>
							</div>
						</td>
					</tr>					
				</template>
			</tbody>
		</table>
	</div>
</template>
<script>
	import { ref,reactive, onMounted } from 'vue';
	import axios from 'axios';
	export default{
		setup(){
			const visitors  = ref([]);
			const errors  = ref([]);
			const visitor_id  = ref('');
			let exit_visitor_id  = ref('');
			const form = reactive({
				log_id:'',
				first_name:'',
				last_name:'',
				phone_number:'',
				in_time:'',
				out_time:''
			});
			const search = reactive({
				from_date:'',
				to_date:'',
				phno:''
			});
			const exit = reactive({
				out_time:''
			});

			const getEmployee = async() =>{
				let res = await axios.get('api/visitors');
				visitors.value = res.data;
			}

			const deleteVisitor = async(id)=>{
                if(confirm('Are you sure want to delete?')){
                    await axios.delete('api/visitors/'+ id)
                    getEmployee()
                }
			}

            const exitVisitor = async(id)=>{
                exit_visitor_id = id;
			}
			const visitorOutTime = async() => {
				console.log(exit_visitor_id)
				await axios.patch('api/visitors/exit-visitor/'+ exit_visitor_id,exit)
				exit.out_time = ''
				$("#exitModal").modal('hide');
            	getEmployee()
			}

            const searchVisitor = async()=>{
                    let res = await axios.post('api/visitors/search',search)
					visitors.value = res.data;                   
			}

			const storeVisitor = async() => {
				try{
					await axios.post('api/visitors',form)
					getEmployee()
					formReset()
					$("#myModal").modal('hide');
				}catch(e){
					if(e.response.status == 422){
						var data = [];
						for(const key in e.response.data.errors){
							data.push(e.response.data.errors[key][0]);
						}
						errors.value = data;
					}
				}
			}
			
			const updateVisitor = async() => {
				try{
					await axios.patch('api/visitors/' + visitor_id.value,form)
					getEmployee()
					formReset()
					$("#myModal").modal('hide');
				}catch(e){
					if(e.response.status == 422){
						var data = [];
						for(const key in e.response.data.errors){
							data.push(e.response.data.errors[key][0]);
						}
						errors.value = data;
					}
				}
			}

			const editVisitor = (visitor)=>{
				visitor_id.value = visitor.id;
				form.log_id = visitor.log_id;
				form.first_name = visitor.first_name;
				form.last_name = visitor.last_name;
				form.phone_number = visitor.phone_number;
				form.in_time = visitor.in_time;
				form.out_time = visitor.out_time;
			}

			onMounted(getEmployee());

			const formReset = () =>{
				visitor_id.value = '';
				form.log_id = '';
				form.first_name = '';
				form.last_name = '';
				form.phone_number = '';
				form.in_time = '';
				form.out_time = '';
			}

			return {
				visitors,
				form,
				search,
				exit,
				storeVisitor,
				errors,
				editVisitor,
				exitVisitor,
				visitorOutTime,
                searchVisitor,
				visitor_id,
				exit_visitor_id,
				updateVisitor,
				formReset,
				deleteVisitor
			}

		}
	}
</script>