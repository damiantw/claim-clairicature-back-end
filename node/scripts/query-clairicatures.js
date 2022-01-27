const path = require("path");
const provider = require(path.join(__dirname, "..", "lib", "provider"));
const clairicatures = require(path.join(
    __dirname,
    "..",
    "lib",
    "clairicatures"
)).connect(provider);

(async () => {
    const result = await clairicatures[process.env.CONTRACT_FUNCTION_NAME](
        ...JSON.parse(process.env.CONTRACT_FUNCTION_ARGS)
    );
    process.stdout.write(JSON.stringify({ result }));
})();
