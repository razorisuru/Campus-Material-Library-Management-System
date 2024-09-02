import sys
import PyPDF2
import openai

def summarize_pdf(pdf_path):
    pdf_file = open(pdf_path, "rb")
    pdf_reader = PyPDF2.PdfReader(pdf_file)

    openai.api_key = 'pk-FlcimbdWcfAEfryzTjywVXQQjpbRpjcjITIrmuBPKuTfdXQY'
    openai.base_url = "https://api.pawan.krd/cosmosrp/v1/"

    summaries = []
    for page_num in range(len(pdf_reader.pages)):
        page_text = pdf_reader.pages[page_num].extract_text()
        response = openai.chat.completions.create(
            model="pai-001-light",
            messages=[
                {
                    "role":"user",
                    "content":f"Summarize this: {page_text}"
                }
            ]
        )
        page_summary = response.choices[0].message.content
        summaries.append(page_summary)

    return summaries

if __name__ == "__main__":
    pdf_path = sys.argv[1]
    summary = summarize_pdf(pdf_path)
    for page in summary:
        print(page)
