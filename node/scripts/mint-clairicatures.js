const path = require("path");
const provider = require(path.join(__dirname, "..", "lib", "provider"));
const wallet = require(path.join(__dirname, "..", "lib", "wallet")).connect(
    provider
);
const clairicatures = require(path.join(
    __dirname,
    "..",
    "lib",
    "clairicatures"
)).connect(wallet);

(async () => {
    process.stdout.write(
        JSON.stringify({
            result: await clairicatures.mint(
                process.env.NFT_OWNER_ADDRESS,
                process.env.NFT_ID,
                process.env.NFT_SECRET,
                { gasPrice: process.env.GAS_PRICE }
            ),
        })
    );
})();
