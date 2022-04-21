const validation = new JustValidate("#create_gallery");

validation
    .addField("#title", [
        {
            rule: "required"
        }
    ])
    .addField("#location", [
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
        document.getElementById("create_gallery").submit();
    });













