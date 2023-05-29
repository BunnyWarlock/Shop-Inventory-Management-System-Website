const validation = new JustValidate("#signup");

validation
  .addField("#name", [
    {
      rule: "required"
    }
  ])
  .addField("#email", [
    {
      rule: "required"
    },
    {
      rule: "email"
    },
    {
      validator: (value) => () => {
        return fetch("validate_email.php?email=" + encodeURIComponent(value))
          .then(function(response){
            return response.json();
          })
          .then(function(json){
            return json.available;
          });
      },
      errorMessage: "Email is already taken"
    }
  ])
  .addField('#password', [
    {
      rule: 'required',
    },
    {
      rule: 'password',
    },
  ])
  .addField("#password2", [
    {
      validator: (value, fields) => {
        return value === fields["#password"].elem.value;
      },
      errorMessage: "Password does not match"
    }
  ])
  .onSuccess((event) => {
    document.getElementById("signup").submit();
  })
  .addField('#admin', [
    {
      rule: 'required',
    },
  ])
  .addField("#shop", [
    {
      rule: "required"
    },
    {
      validator: (value, formData) => () => {
        if (formData["#admin"].elem.checked) {
          return fetch("validate_shop.php?shop=" + encodeURIComponent(value))
            .then(function(response){
              return response.json();
            })
            .then(function(json){
              return json.available;
            });
        }
        else {
          return fetch("validate_shop2.php?shop=" + encodeURIComponent(value))
            .then(function(response){
              return response.json();
            })
            .then(function(json){
              return json.available;
            });
        }
      },
      errorMessage: "Invalid Shop Name (Either Shop doesn't exist or Shop name is taken)"
    },
  ]);
