import Vue from 'vue'
import { ValidationProvider} from 'vee-validate';
import { ValidationObserver} from 'vee-validate';
import { extend } from 'vee-validate';

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

import { required, email, size, image, integer} from 'vee-validate/dist/rules';

extend('integer', {
    ...integer,
    message: 'Please enter a valid number'
})
extend('maxFileSize', {
    ...size,
    message:'max size 5MB exceeded',
    validate: value => {
        let kbValue = value.size/1000
        return kbValue < 5000;
    }
});
extend('image', {
    ...image,
    message: 'File type must be an image'
});
extend('required', {
    ...required,
    message: 'This field is required'
});
extend('min',{
    validate(value, args) {
        return value.length >= args.length;
    },
    params: ['length']
});
extend('email', {
    ...email,
    message: 'Please enter valid email'
});
extend('password', {
    params: ['target'],
    validate(value, { target }) {
        return value === target;
    },
    message: 'Password confirmation does not match'
});

