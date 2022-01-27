const ethers = require("ethers");
const fs = require("fs");
const path = require("path");

module.exports = new ethers.Contract(
    process.env.CLAIRICATURES_NFT_CONTRACT_ADDRESS,
    fs
        .readFileSync(path.join(__dirname, "..", "abi", "Clairicatures.json"))
        .toString()
);
