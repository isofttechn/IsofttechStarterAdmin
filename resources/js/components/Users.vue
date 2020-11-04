<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal">Add New User <i class="fa fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Joined Date</th>
                      <th>Modify</th>                      
                  </tr>

                  <tr v-for="user in users.data" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.type | upText }}</td>
                    <td>{{user.created_at| myDate }}</td>
                    <td>
                        <a href="#" @click="editModal(user)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        <a href="#" @click="deleteUser(user.id)">
                            <i class="fa fa-trash red" ></i>
                        </a>
                    </td>
                  </tr>
                 
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="users" @pagination-change-page="getResults">
                </pagination>

              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row no-print">
                <div class="col-12">
                  <a href="" @click.prevent="printPage" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                  <button type="button" class="btn btn-success float-right"><i class="fa fa-credit-card"></i>Export to Excell
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
              
        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5  class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's Info</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

            <form @submit.prevent="editmode ? updateUser() : createUser()">
          <div class="modal-body">
            <div class="form-group">
              <input v-model="form.name" type="text" name="name" 
              placeholder="Enter Name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
              <has-error :form="form" field="name"></has-error>
            </div>

            <div class="form-group">
              <input v-model="form.email" type="email" name="email" 
              placeholder="Enter email"
                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
              <has-error :form="form" field="email"></has-error>
            </div>

            <div class="form-group">
              <input v-model="form.phone" type="text" name="phone" 
              placeholder="Enter phone number"
                class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
              <has-error :form="form" field="phone"></has-error>
            </div>

            <div class="form-group">
              <input v-model="form.title" type="text" name="title" 
              placeholder="Enter job title"
                class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
              <has-error :form="form" field="title"></has-error>
            </div>

              <div class="form-group">
              <textarea v-model="form.bio" name="bio" id="bio" 
              placeholder="Short bio for user (Optional)"
                class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                </textarea>
              <has-error :form="form" field="bio"></has-error>
            </div>

            <div class="form-group">
              <select v-model="form.type" name="type" id="type"
                class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                  <option value="">Select User Role</option>
                   <option value="admin">Admin</option>
                   <option value="user">Standard User</option>
                   <option value="author">Author</option>
               </select> 
              <has-error :form="form" field="type"></has-error>
            </div>
            
             <div class="form-group">
              <input v-model="form.password" type="password" name="password" 
              placeholder="Enter password"
                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
              <has-error :form="form" field="password"></has-error>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
            <button v-show="editmode" type="submit" class="btn btn-primary">Update</button>

          </div>
    </form>      
        </div>
        </div>
        </div>
      <!--End Modal -->
  </div>
    
</template>

<script>
    export default {
        data(){
          return{
            editmode: false,
            users : {}, //This is axios to get data into this object
            form:new Form({
              id: '',
              name: '',
              email: '',
              phone: '',
              city: '',
              state: '',
              country: '',
              title: '',
              password: '',
              type: '',
              bio: '',
             
            })
          }
        },
          methods: {
            //Pagination function
            // Our method to GET results from a Laravel endpoint
            getResults(page = 1) {
              axios.get('api/user?page=' + page) //passin the users table to fetch data from page 1
                .then(response => {
                  this.users = response.data;
                });
            },
            //updateUser Function
            updateUser(id){
              //Start the progressBar before it send a post request
              this.$Progress.start(); 
              //console.log('Editing Data');
              //Passin the edit method
              this.form.put('api/user/'+this.form.id)
              .then(() => {
                $('#addNew').modal('hide')
                swal(
                    'Updated!',
                    'You just updated your info.',
                    'success'
                  )
                  this.$Progress.finish(); 
                   Fire.$emit('AfterCreate');
              })
              .catch(() => {
                //When error occur
              this.$Progress.fail(); 
              });
            },
            //Edit modal
            editModal(user){
              this.editmode = true;
              //Reset the form
              this.form.reset();
              //Show modal form
              $('#addNew').modal('show')
              //Fill pull out data from db for edit
              this.form.fill(user); 
            },
             newModal(){
               this.editmode = false;
              //Reset the form
              this.form.reset();
              //Show modal form
              $('#addNew').modal('show')
            },
            //Called the function deleteUser
            deleteUser(id){
              //SweetAlert start
              swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {

                //Send an ajx request to the server
                if (result.value) {
                this.form.delete('api/user/'+id).then(() =>{
                  swal(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
                   Fire.$emit('AfterCreate');

                //Cache the error
                }).catch(()=> {
                  swal("Failed!", "There was something wrong.", "warning");
                });
                
                }
                
              })
              //SweetAlert start end
            },
            loadUsers(){
              
              if(this.$gate.isAdminOrAuthor()){  
                // if(this.$gate.isAdmin())      Previous        
                axios.get("api/user").then(({data}) => (this.users = data));
              }
            },
            createUser() {
              
              //Start the progressBar before it send a post request
              this.$Progress.start(); 
              //I put api in between them so that when the data is loading, it bring the effect
              
                this.form.post('api/user')

                //If it was successfull .then will run
                .then(() => {
                   Fire.$emit('AfterCreate');
               $('#addNew').modal('hide')
                
                toast({
                  type: 'success',
                  title: 'User created successfully'
                })

                this.$Progress.finish()
                })
                //If it was not successful the cache will run
                .catch(() => {

                })
               //SweetAlert here 
                //Called the global fire
               
            }
          },
        mounted() {
          // Fired event for searching 
          Fire.$on('searching', () => {
            let query = this.$parent.search;
            axios.get('api/findUser?q=' + query)
            .then((data) =>{
              this.users = data.data
            })
            .catch(() => {

            })
          })
            //console.log('Component mounted.')
            this.loadUsers();
            Fire.$on('AfterCreate', () => {
              this.loadUsers()
            })
            //setInterval(() => this.loadUsers(), 3000);  
        }
    }
</script>
