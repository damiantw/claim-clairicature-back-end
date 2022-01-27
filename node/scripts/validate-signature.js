const ethers = require("ethers");

let address;

try {
    address = ethers.utils.verifyMessage(
        process.env.MESSAGE,
        process.env.SIGNATURE
    );
} catch {
    address = ethers.constants.AddressZero;
}

process.stdout.write(JSON.stringify({ result: address }));
