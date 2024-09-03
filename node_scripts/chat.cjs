process.noDeprecation = true;

const OpenAI = require("openai");

const prompt = process.argv[2];
// const pdfPath = "./test.pdf"

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
                content: `${prompt}`,
                // content: "Teach me about CJS",
            },
        ],
    });

    const pageSummary = response.choices[0].message.content;
    summaries.push(pageSummary);

    console.log(summaries.join("\n\n"));
};

summarizePdf();
