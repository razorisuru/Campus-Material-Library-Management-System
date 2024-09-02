# example.py
import sys
# import openai

def main():
    if len(sys.argv) > 1:
        print(f"Argument received: {sys.argv[1]}")
    else:
        print("No argument provided.")

if __name__ == "__main__":
    main()
