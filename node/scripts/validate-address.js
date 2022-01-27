const ethers = require("ethers");

process.stdout.write(
    JSON.stringify({ result: ethers.utils.isAddress(process.env.ADDRESS) })
);
