const OpenAI = require("openai");

const pdfPath = process.argv[2];
// console.log("Hello", pdfPath);

const openai = new OpenAI({
    apiKey: "pk-FlcimbdWcfAEfryzTjywVXQQjpbRpjcjITIrmuBPKuTfdXQY",
    baseURL: "https://api.pawan.krd/cosmosrp/v1/",
});

const summarizePdf = async () => {
    let summaries = [];

    const response = await openai.chat.completions.create({
        model: "pai-001-light",
        messages: [
            {
                role: "user",
                content: `${pdfPath}`,
                // content: "Teach me about CJS",
            },
        ],
    });

    const pageSummary = response.choices[0].message.content;
    summaries.push(pageSummary);

    console.log(summaries.join("\n\n"));
};

summarizePdf();
