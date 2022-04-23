const validation = new JustValidate("#create_art");

validation
    .addField("#title", [
        {
            rule: "required"
        }
    ])
    .addField("#story", [
        {
            rule: "required"
        }
    ])
    .addField("#price", [
        {
            rule: "required"
        }
    ])

    .onSuccess((event) =>
    {
        document.getElementById("create_art").submit();
    });













