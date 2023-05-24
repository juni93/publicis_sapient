<form id="dynamic-form" action="#" method="POST">
    @csrf

    <div class="form-fields">
        <!-- Form fields will be dynamically added here -->
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@section('scripts')
<style>
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box; /* Add this line to fix the width issue */
    }

    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }
</style>
    <script>
        var formJson = {!! $form !!};
        var fields = formJson.form.fields;

        var form = document.getElementById('dynamic-form');
        var formFieldsContainer = form.querySelector('.form-fields');

        form.addEventListener('submit', function(event) {
            if (!validateForm()) {
                event.preventDefault();
            }
        });

        fields.forEach(function(field) {
            var fieldGroup = createFieldGroup(field);
            formFieldsContainer.appendChild(fieldGroup);
        });

        function createFieldGroup(field) {
            var fieldGroup = document.createElement('div');
            fieldGroup.classList.add('form-group');

            var label = document.createElement('label');
            label.setAttribute('for', field.label);
            label.innerText = field.label;
            fieldGroup.appendChild(label);

            var input = createInputField(field);
            fieldGroup.appendChild(input);

            var errorContainer = createErrorContainer(field.label);
            fieldGroup.appendChild(errorContainer);

            return fieldGroup;
        }

        function createInputField(field) {
            var input;

            if (field.type === 'text') {
                input = document.createElement('input');
                input.setAttribute('type', 'text');
                input.setAttribute('name', field.label);
                input.setAttribute('id', field.label);
                input.setAttribute('placeholder', field.placeholder);
            } else if (field.type === 'password') {
                input = document.createElement('input');
                input.setAttribute('type', 'password');
                input.setAttribute('name', field.label);
                input.setAttribute('id', field.label);
                input.setAttribute('placeholder', field.placeholder);
            } else if (field.type === 'textarea') {
                input = document.createElement('textarea');
                input.setAttribute('name', field.label);
                input.setAttribute('id', field.label);
                input.setAttribute('placeholder', field.placeholder);
            }

            // Add more input types and attributes as needed

            input.addEventListener('input', function() {
                validateField(field, input);
            });

            return input;
        }

        function createErrorContainer(fieldLabel) {
            var errorContainer = document.createElement('div');
            errorContainer.classList.add('error-message');
            errorContainer.setAttribute('id', fieldLabel + '-error');

            return errorContainer;
        }

        function validateForm() {
            var isValid = true;

            fields.forEach(function(field) {
                var input = form.querySelector('[name="' + field.label + '"]');
                isValid = validateField(field, input) && isValid;
            });

            return isValid;
        }

        function validateField(field, input) {
            var value = input.value.trim();
            var validationType = field.validation;
            var errorMessage = '';
            var errorContainer = document.getElementById(field.label + '-error');

            if (validationType === 'numeric') {
                if (!value.match(/^\d+$/)) {
                    isValid = false;
                    errorMessage = 'Please enter a numeric value.';
                }
            } else if (validationType === 'string') {
                if (value === '') {
                    isValid = false;
                    errorMessage = 'Please enter a value.';
                }
            } else if (validationType === 'password') {
                if (value.length < 8) {
                    isValid = false;
                    errorMessage = 'Password must be at least 8 characters long.';
                }
            } else if (validationType === 'email') {
                if (!value.match(/^[^\s@]+@[^\s@]+.[^\s@]+$/)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid email address.';
                }
            } else if (validationType === 'alpha-numeric') {
                if (!value.match(/^[a-zA-Z0-9]+$/)) {
                    isValid = false;
                    errorMessage = 'Please enter only alphanumeric characters.';
                }
            }
            errorContainer.innerText = errorMessage;

            return isValid;
        }
    </script>
