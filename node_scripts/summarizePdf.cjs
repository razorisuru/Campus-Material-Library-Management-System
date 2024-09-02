process.noDeprecation = true;

const fs = require("fs");
const pdfParse = require("pdf-parse");
const OpenAI = require("openai");

const pdfPath = process.argv[2];
// const pdfPath = "./test.pdf"
const pdfData = fs.readFileSync(pdfPath);

const parsePdf = async (data) => {
    const pdf = await pdfParse(data);
    return pdf.text;
};

const openai = new OpenAI({
    apiKey: "pk-FlcimbdWcfAEfryzTjywVXQQjpbRpjcjITIrmuBPKuTfdXQY",
    baseURL: "https://api.pawan.krd/cosmosrp/v1/",
});

const summarizePdf = async () => {
    const text = await parsePdf(pdfData);
    const pages = text.split("\f");

    let summaries = [];
    for (const pageText of pages) {
        const response = await openai.chat.completions.create({
            model: "pai-001-light",
            messages: [
                {
                    role: "user",
                    content: `Summarize this: ${pageText}`,
                    // content: "Teach me about CJS",
                },
            ],
        });

        const pageSummary = response.choices[0].message.content;
        summaries.push(pageSummary);
    }
    console.log(summaries.join("\n\n"));
};

summarizePdf();
