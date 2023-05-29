const validation = new JustValidate("#item");

validation
  .addField("#name", [
    {
      rule: "required"
    },
  ])
  .addField("#cp", [
    {
      rule: "required"
    },
    {
      rule: 'minNumber',
      value: 0,
    },
  ])
  .addField("#sp", [
    {
      rule: "required"
    },
    {
      rule: 'minNumber',
      value: 0,
    },
  ])
  .addField("#mina", [
    {
      rule: "required"
    },
    {
      rule: 'minNumber',
      value: 0,
    },
  ])
  .addField("#maxa", [
    {
      rule: "required"
    },
    {
      validator: (value, fields) => {
        return parseInt(value) >= parseInt(fields["#mina"].elem.value);
      },
      errorMessage: "Maximum amount cannot be lower than Minimum amount"
    }
  ])
  .onSuccess((event) => {
    document.getElementById("item").submit();
  });
