#API DOCUMENTATION
1. Git clone this repo into fbis folder
2. To run locally, ensure your wamp/xamp is running
3. Make use of postman (or any other api testing tool) to test any of the following end points:

##extractvalidgenes
(●	Given a DNA sequence, extract all the valid genes)
- send get request to  http://127.0.0.1/fbis/fbis_connect.php
- add Token 39109f7df56e1051c399e685066bb852
- send dna and process as extractvalidgenes

Sample call http://127.0.0.1/fbis/fbis_connect.php?dna=GHJATGJTAAJFTGAJIDTCATGJKDFHYLOPTAAJATGTAADFD&process=extractvalidgenes
sample response:

{
    "result": {
        "validgenes": {
            "1": {
                "gene": "ATGJTAAJFTGA",
                "cgratio": "2/12"
            },
            "2": {
                "gene": "ATGJKDFHYLOPTAA",
                "cgratio": "1/15"
            }
        },
        "genecount": 2
    }
}

##calculatecgr
(●	Given a gene, calculate the CG ratio)
- send get request to http://127.0.0.1/fbis/fbis_connect.php
- add Token 39109f7df56e1051c399e685066bb852
- send valid gene and process as calculatecgr

Sample call http://127.0.0.1/fbis/fbis_connect.php?gene=ATGJTAAJFTGA&process=calculatecgr
sample response:
{
    "result": {
        "gene": "ATGJTAAJFTGA",
        "cgratio": "2/12"
    }
}






#ASSUMPTION

- DNA
    Deoxyribonucleic acid, more commonly known as DNA, is a complex molecule that contains all of the information necessary to build and maintain an organism. DNA is made of chemical building blocks called nucleotides. 
    Each nucleotide consists of three components:
    - 	a nitrogenous base: cytosine (C), guanine (G), adenine (A) or thymine (T)
    -	a five-carbon sugar molecule (deoxyribose in the case of DNA)
    -	a phosphate molecule / backbone

- Gene
The gene is the basic physical and functional unit of heredity. It consists of a specific sequence of nucleotides at a given position. The familiar Needle in Haystacks is analogous to Genes in DNA. A smallest sample of DNA is given below:

dna = "GHJATGJTAAJFTGAJIDTCATGJKDFHYLOPTAAJATGTAADFD"

- Codon
To extract information from a DNA, we use codons.  A codon is a sequence of three DNA or RNA nucleotides that corresponds with a specific amino acid or stop signal during protein synthesis. We have start and stop codons as shown below:
- Start Codon:
    - ATG - sequence of Adenine, Thymine and Guanine

- Stop Codons:
    - TAA - sequence of Thymine, Adenine, and Adenine.
    - TAG - sequence of Thymine, Adenine and Guanine.
    - TGA - sequence of Thymine, Guanine and Adenine.






