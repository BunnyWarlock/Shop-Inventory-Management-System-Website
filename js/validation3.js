const validation = new JustValidate("#item");

validation
  .addField("#type", [
    {
      rule: "required"
    },
  ])
  .addField("#amount", [
    {
      rule: "required"
    },
  ])
  .addField("#quantity", [
    {
      rule: "required"
    },
    {
      validator: (value, formData) => {
        if (formData["#type"].elem.value === "SELL") {
          return parseInt(value) <= parseInt(formData["#amount"].elem.value);
        } else {
          return 0 == 0;
        }
      },
      errorMessage: "Cannot sell more items than currently in the inventory"
    }
  ])
  .onSuccess((event) => {
    document.getElementById("item").submit();
  });
