const ethers = require("ethers");
const generatePassword = require("omgopass");
const fs = require("fs");

if (fs.existsSync("wallet.json") || fs.existsSync(".secret")) {
    console.error("WALLET_ALREADY_EXISTS");
    process.exit(1);
}

async function main() {
    const wallet = ethers.Wallet.createRandom();
    const password = generatePassword();
    console.log(`ADDRESS: ${wallet.address}`);
    console.log(`PASSWORD: ${password}`);
    fs.writeFileSync("wallet.json", await wallet.encrypt(password));
    fs.writeFileSync(".secret", wallet.privateKey);
}

main()
    .then(() => process.exit(0))
    .catch((error) => {
        console.error(error);
        process.exit(1);
    });
