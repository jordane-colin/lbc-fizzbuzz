db.createUser(
    {
        user: "fizzbuzz",
        pwd: "secret",
        roles: [
            {
                role: "readWrite",
                db: "fizzbuzz"
            }
        ]
    }
);
