// SPDX-License-Identifier: UNLICENSED

pragma solidity ^0.8.9;

import "@openzeppelin/contracts/token/ERC721/extensions/ERC721Enumerable.sol";
import "@openzeppelin/contracts/token/ERC721/extensions/ERC721URIStorage.sol";
import "@openzeppelin/contracts/security/Pausable.sol";
import "@openzeppelin/contracts/access/Ownable.sol";

contract Clairicatures is
    ERC721Enumerable,
    ERC721URIStorage,
    Pausable,
    Ownable
{
    struct Employee {
        string name;
        string tokenUri;
        bytes32 secretHash;
        bool exists;
    }

    mapping(uint256 => Employee) public employees;

    constructor() Ownable() Pausable() ERC721("Clairicatures", "CLAIR") {
        employees[1] = Employee(
            "Adam Campbell",
            "ipfs://QmaFEJqsbZrGwJ83Yh5fp9K9BKma7EZzn43Vo3U7nYLjCe",
            0x06f601b2fef08108c6de1ee12b151dd45a04ade7b605d8e137724acee0f75139,
            true
        );
        employees[2] = Employee(
            "Adam Rawot",
            "ipfs://QmWF5hhYJtvRPKUrFFpjPUe1NbndobPipFyVeHH4QcXdDz",
            0xbe2019f221fe3843789440aff4bab38f61e91112f0f8ecc1a0a9acce773e028e,
            true
        );
        employees[3] = Employee(
            "Alex Kostecki",
            "ipfs://QmVWnLHbsi4aqJZGmqqh1km4uNBqui6tCDoQAptJHGvyFU",
            0x5604cd19ca63711ce95320be45a392ea7b73d3dabfdd144ba464464adfbcf81c,
            true
        );
        employees[4] = Employee(
            "Amrita Deol",
            "ipfs://QmYC3j9ww8JmjxxK6SsznS4TQHWXBnuSSVvL2apBbyy6S4",
            0x5f230e5d2d6a6b55089f6c86803190ad3c000ccf14131454b9e27b748e20299b,
            true
        );
        employees[5] = Employee(
            "Andrew Lineback",
            "ipfs://QmSDXBn9FmdwcZehX9jGNyButzNWHEYfBozZrKduGBtPqM",
            0x1e2009c1454068e4e992a6b21ac0656b2f1dab4061db187c533c2053016f66f9,
            true
        );
        employees[6] = Employee(
            "Anne Gottwalt",
            "ipfs://QmYHSHpErGcieX626ZGoyw9m7N73c6c2Rmny7iSsi4fk6D",
            0x31bec267940c8014f026a16a8cafea71636771aabf5f9cf6802fe1cee889dce1,
            true
        );
        employees[7] = Employee(
            "Anya Mezak",
            "ipfs://QmY4CxfcuS9bWH9ZvyGsiidp283kLZnjt6tBzx7sWYkSRc",
            0x6cfa27ac60f015e3248da09c0a0a826507275207bac86521074641b1fe335d87,
            true
        );
        employees[8] = Employee(
            "Arslan Mahmood",
            "ipfs://QmNXL5VSDkt57dyf9tQvPXGAoaL3uignhrU7uC46HH5f7q",
            0x6c572250c9dadae2fe751f50692ac2b148f3ec065a3431fba666bf4a7aa3f819,
            true
        );
        employees[9] = Employee(
            "Damian Crisafulli",
            "ipfs://QmNzpesUHYoVDTMyt6EqaNZRHz6KBcgT9131MiuEazTs5Q",
            0xf3fdc8934e96c3f2057cdfa6f5b620ba71d76813620f5d511cd65bfa164d1ec6,
            true
        );
        employees[10] = Employee(
            "Dan Mayton",
            "ipfs://QmZteHpnz6nVceXvga4ttnuxZzttuJhvusLWsbXPvtNEqW",
            0xe9825ceb526a7f498fd74296f2f85061a71d03de873dac68d8f7551c604c11f2,
            true
        );
        employees[11] = Employee(
            "Denise Uy",
            "ipfs://QmcUTgN1JfS47DGyyFsh5KFLR3F84nYbUpfxr6T2E9aXzx",
            0x6c6b206a3d89d442a6b802bd82fbed58c5818e8b875b136e7ea5b58fa2ff9f12,
            true
        );
        employees[12] = Employee(
            "Drew Warkentin",
            "ipfs://QmVVutRjLbyQPGrVEKUnUUcUkm4VYdpcTkkjKdjC4hfbgL",
            0x90f2be911206368af896d03dc4454b76e67181c5e12da6d1006dbbb71e4897b9,
            true
        );
        employees[13] = Employee(
            "Erich Nussbaumer",
            "ipfs://QmWxrgp7FEcHCjE9kXkEnuVHeFcxJSXp9nJnTY7F7UTjmB",
            0x0c753dd76bf0ddf74f23f3bf514cfb7ec76ee0089b5f5c91d9765ffcc3a84824,
            true
        );
        employees[14] = Employee(
            "Erik Webb",
            "ipfs://QmQd7BLvJ7aMv1c1ihjGwRdxPL5rnfuoCMhQ6hUfepY27x",
            0x92b74736314b97408003aca36d5fa4688154decc5527c259b004a169599f8d0c,
            true
        );
        employees[15] = Employee(
            "Erin Pan",
            "ipfs://QmbG8GdzTz6i1ZrBVm7kJC46URRmr7iuz16nFmtx3rjDEY",
            0x4b7626c4b16efba57fd634c82a94f994a82d176a51ce9066e3d7fb8023d96386,
            true
        );
        employees[16] = Employee(
            "Hope Chen",
            "ipfs://QmPCqVaaQ7GnuQ2UoNmgFBUPYZMFgmrW3da7F1EP29Eswz",
            0xce919a648a0a1a64b299391894984ab12c583d6c1a1ec31ea76861637abf86b6,
            true
        );
        employees[17] = Employee(
            "Hunter Smith",
            "ipfs://QmUG8jpzpc7F4cK28YEYBk4Y9KYQpbdgR56oxFcpfgi51J",
            0x91797292c77a8503937060939df56dd76db885457b2ea6a31211ab09035402fe,
            true
        );
        employees[18] = Employee(
            "James Gifford",
            "ipfs://QmSGxW7MesXdXbykDxEnJhZ7G8GTj8bFQC61wZq3qRwddz",
            0x24fb2f36a736cc340268f11ecc478a3c90f6b76032c08fc751056f04aba14bbc,
            true
        );
        employees[19] = Employee(
            "Jessica Figueroa",
            "ipfs://QmU8S2dj75c7Tp2sEXR2ZXja6XfRJ63xCq45PkPb92X7bq",
            0xf1713cc994908707539aef7eb845fcd4c1c4113eb3914bf43e09d7b8e6bc8d20,
            true
        );
        employees[20] = Employee(
            "Joe Moore-Turnage",
            "ipfs://QmQ8MwYhLxk4sKU3LS1DoouTQcN2pVXHWhzYjGpBu6Dzzt",
            0xc202a4fb78a1d147c3f4a8a5f0e647c05bd5812cd32a36b2689eb159a4cd6eab,
            true
        );
        employees[21] = Employee(
            "Julie Gele",
            "ipfs://QmR39KT4rUNQFwn1NN8eJYRwsmu5FYq7GUXgEKJ8BzDUaZ",
            0x64882aa7af67b8d28261739cfeda93908ebac8bba5e92effefc9f8220e65d374,
            true
        );
        employees[22] = Employee(
            "Karla Castaneda",
            "ipfs://QmW4oDTs26oLjoERBi2GByDYZAh4E9utj2VHpWbxEUBeev",
            0xfe3265b40174950954e95196d01fd5341912bf0873fb5cb645797f93791f9de4,
            true
        );
        employees[23] = Employee(
            "Kira Walter",
            "ipfs://QmVsM8Ws9Ytb7xg1RW2ricaeyVuTsDZDnmvKj5HSEjD9Eu",
            0x68d7aadfb9b3ec5a24db09ec1600b4b5af094546c83a38d11a977e6dc548d257,
            true
        );
        employees[24] = Employee(
            "Konstantin Lafchis",
            "ipfs://QmfFcQEv5wXt7CBqCE7yHbzDe9AKu6ECB9HdmpFpiAwtZT",
            0x7a27ca2ae7c361835df20aae87e21038a082185cf0eb7e9e7318a574d9b884be,
            true
        );
        employees[25] = Employee(
            "Lance Katigbak",
            "ipfs://QmfFAJms5anr8Y19ubUDMYigLftndStDsqqdJk9bw67Jof",
            0x76b2c204ebde8e282392d5c22c547a470c1405c5e68a2367a0d52160f7a3f5ca,
            true
        );
        employees[26] = Employee(
            "Lubna Rahmani",
            "ipfs://Qmef61RQnvNZfdonFw3UqVEk2WHnH7BwxD97x5pVdBxi3k",
            0x6e82107b550b2e11265d6b0719bc3e843952893c11f81500687dc913f6012836,
            true
        );
        employees[27] = Employee(
            "Maria Scalici",
            "ipfs://QmcM1auxZknfTuHtyUsUUme7dWrRX7yWhVGMPP11RggQpt",
            0x324a21796a319ad6296695372c5f3f66008321b482b3c579eee65b948cf9302d,
            true
        );
        employees[28] = Employee(
            "Marina Rodrigues",
            "ipfs://QmSX5ov8BZfAnSrigBLiDY3e3jZhz5NYYMrf9poQHkW52Q",
            0x9a90d1dc4a3d8de36de13aedf05635a89f2670c4fcde26744704bf0798f4aed1,
            true
        );
        employees[29] = Employee(
            "Mark Goldstein",
            "ipfs://QmdDh19KJz7XkgSnnHVtnXbc51ZhTdGSpTiwxX7EKcfmfn",
            0x75e60630f507b22b94d8749343a742b198c25367466057cbf05336e99701054a,
            true
        );
        employees[30] = Employee(
            "Marlene Carrasco",
            "ipfs://Qmdh8BXC1Td7cmuxzJNpP7pNmGr1Xap33PXSPJoqQDPBjP",
            0xb87a4028f478739726a4a9e735e8db7fd036c3a04a2904861bf5d2996fefaf21,
            true
        );
        employees[31] = Employee(
            "Matthew Jung",
            "ipfs://QmeXuFkNEZsK5JyfYe2NWdpNLmpo5ojwQvLgG9LnqJmYKa",
            0xe7df13d531d2d9bcd7058d012d59fb0843110e41c6e5bf3d28a1c897903bb78d,
            true
        );
        employees[32] = Employee(
            "Melissa Pastore",
            "ipfs://QmaedYzQbN7NFCmHmWE7zENfkwBXB4ipNnUXZ8Eb4fP6i2",
            0x5207454cf7ff0912bd921afba1274951bd10f5f1ac706020f2b30dfe6877cd4d,
            true
        );
        employees[33] = Employee(
            "Moaz Selim",
            "ipfs://QmZgAJqAYYQNyuYigBkaH2Fa4uL87844fGfdDQkdvA8Azr",
            0x721989e825e47085816fe5d5d9a54802898bd6ef749fb8f8e0a897ea324df9f3,
            true
        );
        employees[34] = Employee(
            "Nico Simko",
            "ipfs://QmepeMLw5uUU9M5LnHX28RXF6FgpPDZfgoovSqAM5nNusM",
            0xd35de33609ebe44f97435053ad297a1de8b316920ec1563e8d44d43d3adf3e37,
            true
        );
        employees[35] = Employee(
            "Niko Zurita",
            "ipfs://QmZF4EAPzMZjF49UodTrbmw5JVPHeVEb7LaNyWX6EmjPY8",
            0xc163c10e6a3a64e707828c2e4904dd892f2082adc88391430a3bf97bfd17deb7,
            true
        );
        employees[36] = Employee(
            "Olivia Morelos",
            "ipfs://QmNpa8NKYmHnU1ZRkHqzPa8LUv78QNFxWiGDFushDYUVo6",
            0x90ce8996bc706788817d1e0a86f3665e3c2273baee2d73524b3594ccad703970,
            true
        );
        employees[37] = Employee(
            "Richard Jacobsen",
            "ipfs://QmQaYU7cdsmXD1F5PDap9CCvAnDuM63fVAsxqfBkWQzhYR",
            0xb581616d696020a8758b191eb547b27b13488d24457dde3ce830f389aebbbfb6,
            true
        );
        employees[38] = Employee(
            "Robert Ambrose",
            "ipfs://QmcX43iTL5C6B2XKaaAvfbEyhbdCwLVjNcJPQrqBVFTKU4",
            0x797ed1332a22257fcfa05179c6f28dcd41781b887782875af63141f7de52f189,
            true
        );
        employees[39] = Employee(
            "Scott Ferguson",
            "ipfs://QmdD3f1S5U2er1x9XooKWXYsfRcGBEZnc7YdLMUzr9EoAY",
            0xfc760e53f867567237f03af99334e5473856e322f0ba7cd2fb362e7d043ce1e9,
            true
        );
        employees[40] = Employee(
            "Sean Naughton",
            "ipfs://QmfTfyHWdhJ8aZ234h2PeGy2s8h8H2nSpWs2MGeVPQeqWr",
            0xea785c60d9e9d3c0de83b32c54268c02f5867b61c171424ad0bbbe67f5fdca77,
            true
        );
        employees[41] = Employee(
            "Suresh Rajan",
            "ipfs://QmbYTR1JqV5k4tNpiYQdx8VgzNdf3otWZWCjH7tsjLCUic",
            0xabcc316e90223f89d64b24bf94fe6495ba0a18bc4742237badc6c1cbfc2ab1cc,
            true
        );
        employees[42] = Employee(
            "Swandala Jones",
            "ipfs://QmRkAPijPhqHFURGNKHvpw27DjBHHYzVimECps9ZCruGoD",
            0x2b30bae36b85b2cc9efe181a5bb5f64bc6c0c46e3677d716f903596ba55615a2,
            true
        );
        employees[43] = Employee(
            "Tristan Payne",
            "ipfs://QmPnEZjVFnHwXsz1QXntPWmnavo5VEEd6cPxucrWgw83gn",
            0x31ca0accc25f3d73d0bcc8651cb3746a8e948fb7a27e33bfafefafa56892d312,
            true
        );
        employees[44] = Employee(
            "Wesley Cash",
            "ipfs://QmWiMx3nUY7trL6jsiGHZHqLqByv6iTFmsNL5UkSEnudEz",
            0xc5886656a18633704c79b618a39929bdc27854111381f374517031618998040e,
            true
        );
    }

    function mint(
        address to,
        uint256 employeeId,
        string memory secret
    ) public {
        Employee storage employee = employees[employeeId];
        require(employee.exists, "Employee does not exist");
        require(_validateSecret(secret, employee.secretHash), "Invalid secret");
        ERC721._safeMint(to, employeeId);
        ERC721URIStorage._setTokenURI(employeeId, employee.tokenUri);
    }

    function addEmployee(
        uint256 employeeId,
        string memory name,
        string memory tokenUri,
        bytes32 secretHash
    ) public onlyOwner {
        Employee storage employee = employees[employeeId];
        require(!employee.exists, "Employee ID already exists");
        employees[employeeId] = Employee(name, tokenUri, secretHash, true);
    }

    function burn(uint256 tokenId) public onlyOwner {
        _burn(tokenId);
    }

    function tokenURI(uint256 tokenId)
        public
        view
        virtual
        override(ERC721, ERC721URIStorage)
        returns (string memory)
    {
        return ERC721URIStorage.tokenURI(tokenId);
    }

    function pause() public onlyOwner {
        Pausable._pause();
    }

    function unpause() public onlyOwner {
        Pausable._unpause();
    }

    function supportsInterface(bytes4 interfaceId)
        public
        view
        virtual
        override(ERC721, ERC721Enumerable)
        returns (bool)
    {
        return ERC721Enumerable.supportsInterface(interfaceId);
    }

    function _beforeTokenTransfer(
        address from,
        address to,
        uint256 tokenId
    ) internal virtual override(ERC721, ERC721Enumerable) {
        require(!paused(), "ERC721Pausable: token transfer while paused");
        ERC721Enumerable._beforeTokenTransfer(from, to, tokenId);
    }

    function _burn(uint256 tokenId)
        internal
        virtual
        override(ERC721, ERC721URIStorage)
    {
        delete employees[tokenId];
        ERC721URIStorage._burn(tokenId);
    }

    function _validateSecret(string memory secret, bytes32 secretHash)
        internal
        virtual
        returns (bool)
    {
        return keccak256(abi.encodePacked(secret)) == secretHash;
    }
}
