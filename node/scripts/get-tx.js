const path = require("path");
const provider = require(path.join(__dirname, "..", "lib", "provider"));

(async () => {
    process.stdout.write(
        JSON.stringify({
            result: await provider.getTransaction(process.env.TRANSACTION_HASH),
        })
    );
})();
