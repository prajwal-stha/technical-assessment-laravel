<template>
    <div class="container">
        <div class="card p-lg-1">
            <div class="card-title">
                <h2> Review for customer: {{ customerDetails.name }}</h2>
            </div>
            <div class="card-body">
                <ValidationObserver ref="observer" v-slot="{ invalid }" tag="form" @submit.prevent="update()">
                    <div class="form-body">
                        <v-row>
                            <v-col cols="12" md="6">
                                <ValidationProvider
                                    name="name"
                                    rules="required"
                                    v-slot="{ errors }"
                                    class="validation-wrapper">
                                    <v-text-field v-model="customerDetails.name" name="name"
                                                  label="Name *">
                                    </v-text-field>
                                    <span v-if="errors.length" class="error-message">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </v-col>
                            <v-col cols="12" md="6">
                                <ValidationProvider
                                    name="email"
                                    rules="required|email"
                                    v-slot="{ errors }"
                                    class="validation-wrapper">
                                    <v-text-field v-model="customerDetails.email" name="name" type="email"
                                                  label="Email *">
                                    </v-text-field>
                                    <span v-if="errors.length" class="error-message">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="6">
                                <ValidationProvider name="phone" rules="required"
                                                    v-slot="{ errors }" class="validation-wrapper">
                                    <v-text-field v-model="customerDetails.phone" name="phone" type="number"
                                                  label="Phone *">
                                    </v-text-field>
                                </ValidationProvider>
                                <span v-if="errors.length" class="error-message">{{ errors[0] }}</span>
                            </v-col>
                            <v-col cols="12" md="6">
                                <ValidationProvider
                                    name="nationality"
                                    rules="required"
                                    v-slot="{ errors }"
                                    class="validation-wrapper">
                                    <v-text-field v-model="customerDetails.nationality" name="nationality" type="text"
                                                  label="Nationality *">
                                    </v-text-field>
                                    <span v-if="errors.length" class="error-message">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="6">
                                <ValidationProvider name="phone" rules="required"
                                                    v-slot="{ errors }" class="validation-wrapper">
                                    <v-text-field v-model="customerDetails.address" name="address" type="text"
                                                  label="Address *">
                                    </v-text-field>
                                    <span v-if="errors.length" class="error-message">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </v-col>
                            <v-col cols="12" md="6">
                                <ValidationProvider
                                    name="gender"
                                    rules="required"
                                    v-slot="{ errors }"
                                    class="validation-wrapper">
                                    <v-select
                                        name="gender"
                                        label="Gender *"
                                        :items="genderList"
                                        item-value="value"
                                        item-text="key"
                                        v-model="customerDetails.gender"
                                    ></v-select>
                                    <span v-if="errors.length" class="error-message">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="6">
                                <div class="md-date-picker isDobInserted">
                                    <ValidationProvider v-slot="{ errors }" name="dob" rules="required">
                                        <label class="datepicker-label">Date of birth</label>
                                        <date-picker data-vv-as="dob" v-model="customerDetails.date_of_birth"
                                                     placeholder="Date of birth*" value-type="format"
                                                     :format="dateFormat"
                                                     required :error-messages="errors"></date-picker>
                                        <span v-if="errors.length" class="error-message">{{ errors[0] }}</span>
                                    </ValidationProvider>
                                </div>
                            </v-col>
                            <v-col cols="12" md="6">
                                <ValidationProvider
                                    name="gender"
                                    rules="required"
                                    v-slot="{ errors }"
                                    class="validation-wrapper">
                                    <v-select
                                        name="mode_of_contact"
                                        label="Preferred mode of contact *"
                                        :items="contactModeList"
                                        item-value="value"
                                        item-text="key"
                                        v-model="customerDetails.preferred_contact_mode"
                                    ></v-select>
                                    <span v-if="errors.length" class="error-message">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </v-col>
                        </v-row>
                        <v-row>
                            <div class="card p-2">
                                <div class="card-title text-center">
                                    <h3>Education Details</h3>
                                </div>
                                <div class="card-body">
                                    <div v-for="(education, index) in customerDetails.education_details" :key="index">
                                        <div class="card ">
                                            <v-row>
                                                <v-col cols="12" md="6">
                                                    <ValidationProvider
                                                        :name="`customerDetails.education_details[${index}][education_type]`"
                                                        rules="required"
                                                        v-slot="{ errors }"
                                                        class="validation-wrapper">
                                                        <v-select
                                                            :name="`customerDetails.education_details[${index}][education_type]`"
                                                            label="Education Type"
                                                            :items="educationTypeList"
                                                            item-value="value"
                                                            item-text="key"
                                                            v-model="education.education_type"
                                                        ></v-select>
                                                        <span v-if="errors.length" class="error-message">{{
                                                                errors[0]
                                                            }}</span>
                                                    </ValidationProvider>
                                                </v-col>
                                                <v-col cols="12" md="6">
                                                    <ValidationProvider
                                                        :vid="`customerDetails.education_details[${index}][institution_name]`"
                                                        :name="`customerDetails.education_details[${index}][institution_name]`"
                                                        rules="required"
                                                        v-slot="{ errors }"
                                                        class="validation-wrapper">
                                                        <v-text-field
                                                            v-model="education.institution_name"
                                                            :name="`customerDetails.education_details[${index}][institution_name]`"
                                                            type="text"
                                                            label="Institution Name *">
                                                        </v-text-field>
                                                        <span v-if="errors.length" class="error-message">{{
                                                                errors[0]
                                                            }}</span>
                                                    </ValidationProvider>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" md="6">
                                                    <ValidationProvider
                                                        :vid="`customerDetails.education_details[${index}][institution_address]`"
                                                        :name="`customerDetails.education_details[${index}][institution_address]`"
                                                        rules="required"
                                                        v-slot="{ errors }"
                                                        class="validation-wrapper">
                                                        <v-text-field
                                                            v-model="education.institution_address"
                                                            :name="`customerDetails.education_details[${index}][institution_address]`"
                                                            type="text"
                                                            label="Institution Address *">
                                                        </v-text-field>
                                                        <span v-if="errors.length" class="error-message">{{
                                                                errors[0]
                                                            }}</span>
                                                    </ValidationProvider>
                                                </v-col>
                                                <v-col cols="12" md="6">
                                                    <ValidationProvider
                                                        :name="`customerDetails.education_details[${index}][current_status]`"
                                                        rules="required"
                                                        v-slot="{ errors }"
                                                        class="validation-wrapper">
                                                        <v-select
                                                            :name="`customerDetails.education_details[${index}][current_status]`"
                                                            label="Current Status"
                                                            :items="currentEducationStatusList"
                                                            item-value="value"
                                                            item-text="key"
                                                            v-model="education.current_status"
                                                        ></v-select>
                                                        <span v-if="errors.length" class="error-message">{{
                                                                errors[0]
                                                            }}</span>
                                                    </ValidationProvider>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" md="4"
                                                       :v-if="customerDetails.education_details[index].current_status === 'Ongoing' || customerDetails.education_details[index].current_status === 'Completed' ">
                                                    <div class="md-date-picker isDobInserted">
                                                        <ValidationProvider
                                                            v-slot="{ errors }"
                                                            :name="`customerDetails.education_details[${index}][start_date]`"
                                                            rules="required">
                                                            <label class="datepicker-label">Start Date</label>
                                                            <date-picker data-vv-as="dob"
                                                                         v-model="education.start_date"
                                                                         placeholder="Start date*" value-type="format"
                                                                         :format="dateFormat"
                                                                         required
                                                                         :error-messages="errors"></date-picker>
                                                            <span v-if="errors.length" class="error-message">{{
                                                                    errors[0]
                                                                }}</span>
                                                        </ValidationProvider>
                                                    </div>
                                                </v-col>
                                                <v-col cols="12" md="4" v-if="checkEducationCompleted(index)">
                                                    <ValidationProvider
                                                        :vid="`customerDetails.education_details[${index}][grade]`"
                                                        :name="`customerDetails.education_details[${index}][grade]`"
                                                        rules="required"
                                                        v-slot="{ errors }"
                                                        class="validation-wrapper">
                                                        <v-text-field
                                                            v-model="education.grade"
                                                            :name="`customerDetails.education_details[${index}][grade]`"
                                                            type="text"
                                                            label="Grade *">
                                                        </v-text-field>
                                                        <span v-if="errors.length" class="error-message">{{
                                                                errors[0]
                                                            }}</span>
                                                    </ValidationProvider>
                                                </v-col>
                                                <v-col cols="12" md="4"
                                                       v-if="checkEducationCompleted(index)">
                                                    <div class="md-date-picker isDobInserted">
                                                        <ValidationProvider
                                                            v-slot="{ errors }"
                                                            :name="`customerDetails.education_details[${index}][end_date]`"
                                                            rules="required">
                                                            <label class="datepicker-label">End Date</label>
                                                            <date-picker data-vv-as="dob"
                                                                         v-model="education.end_date"
                                                                         placeholder="End date*" value-type="format"
                                                                         :format="dateFormat"
                                                                         required
                                                                         :error-messages="errors"></date-picker>
                                                            <span v-if="errors.length" class="error-message">{{
                                                                    errors[0]
                                                                }}</span>
                                                        </ValidationProvider>
                                                    </div>
                                                </v-col>
                                            </v-row>
                                        </div>
                                        <div class="form-group text-center m-3">
                                            <button
                                                @click="removeEducationDetails(customerDetails.education_details[index].guid,index)"
                                                type="button"
                                                class="btn-sm btn-secondary">
                                                <i class="fa fa-minus">Remove Education Details</i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group text-center m-3">
                                        <button @click="addEducationDetails" type="button" class="btn btn-secondary">
                                            <i class="fa fa-plus">Add Details</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </v-row>
                        <v-row>
                            <div class="btn-wrapper text-center">
                                <v-btn type="submit" :loading="loading" depressed large class="btn-continue-form"
                                       color="primary">
                                    Update
                                </v-btn>
                            </div>
                        </v-row>
                    </div>
                </ValidationObserver>
            </div>
        </div>
    </div>
</template>

<script>
import helper from "../../services/helper";

export default {
    name: 'Review',
    data() {
        return {
            customerDetails: {},
            loading: false,
            errors: "",
            dateFormat: "YYYY-MM-DD",
            currentEducationStatusList: [
                {
                    key: "Ongoing",
                    value: "Ongoing"
                },
                {
                    key: "Completed",
                    value: "Completed",
                }
            ],
            educationTypeList: [
                {
                    key: 'School',
                    value: 'School',
                },
                {
                    key: 'HighSchool',
                    value: 'HighSchool',
                },
                {
                    key: 'Bachelors',
                    value: 'Bachelors',
                },
                {
                    key: 'Master',
                    value: 'Master',
                },
                {
                    key: 'Phd',
                    value: 'Phd',
                }
            ],
            genderList: [
                {
                    key: "Male",
                    value: "Male"
                },
                {
                    key: "Female",
                    value: "Female"
                },
                {
                    key: "Others",
                    value: "Others"
                }
            ],
            contactModeList: [
                {
                    key: "Phone",
                    value: "Phone"
                },
                {
                    key: "Email",
                    value: "Email"
                },
                {
                    key: "Both",
                    value: "Both"
                },
                {
                    key: "None",
                    value: "None"
                },
            ],
        }
    },
    mounted() {
        this.fetchCustomerDetail();
    },
    methods: {
        fetchCustomerDetail() {
            let guid = this.$route.params.id;
            axios.get(`/api/admin/customer-details/view/${guid}`)
                .then((response) => {
                    this.customerDetails = response.data
                }).catch((error) => {
                helper.showErrorMsg(error);
                this.$router.push("/admin/home");
            })
        },
        async update() {
            let guid = this.$route.params.id;
            const valid = await this.$refs.observer.validate();
            if (valid) {
                this.loading = true
                axios.patch(`/api/admin/customer-details/update/${guid}`, this.customerDetails)
                    .then((response) => {
                        toastr.success(response.data.message);
                        this.loading = false;
                    }).catch((error) => {
                    this.loading = false;
                    this.$refs.observer.setErrors(error);
                    console.log(error.response);
                    helper.showErrorMsg(error)
                })
            } else {
                let errMsg = document.getElementsByClassName(
                    "error-message"
                )[0];
                errMsg.scrollIntoView({
                    behavior: "smooth",
                    block: "end",
                    inline: "nearest",
                });
                window.scrollTo(0, 0);
            }
        },
        addEducationDetails() {
            this.customerDetails.education_details.push({
                education_type: '',
                institution_name: '',
                institution_address: '',
                start_date: '',
                current_status: null,
                end_date: null,
                grade: null,
            })
        },
        checkEducationCompleted(index) {
            return this.customerDetails.education_details[index].current_status === 'Completed';
        },
        eligibleRemoveTask() {
            if (this.customerDetails.education_details.length > 1) {
                return true;
            }
        },
        removeEducationDetails(guid, index) {
            console.log(guid);
            this.customerDetails.education_details.splice(index, 1);
            if (guid !== undefined){
                axios.delete(`/api/admin/education-detail/delete/${guid}`)
                    .then((response) => {
                        toastr.success(response.data.message);
                    }).catch((error) => {
                    helper.showErrorMsg(error);
                })
            }

        }
    }
}
</script>
