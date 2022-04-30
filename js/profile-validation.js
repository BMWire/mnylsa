const validation = new JustValidate("#create_profile");

validation
    .addField("#img", [
        {
            rule: "required"
        }
    ])
    .addField("#story", [
        {
            rule: "required"
        }
    ])
    .addField("#building", [
        {
            rule: "required"
        }
    ])
    .addField("#street", [
        {
            rule: "required"
        }
    ])
    .addField("#town", [
        {
            rule: "required"
        }
    ])
    .addField("#county", [
        {
            rule: "required"
        }
    ])

    .onSuccess((event) =>
    {
        document.getElementById("create_profile").submit();
    });













