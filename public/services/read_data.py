from pyvi import ViTokenizer # thư viện NLP tiếng Việt
import pickle
import gensim # thư viện NLP

# xử dụng stop word loại bỏ từ không có ý nghĩa trong việc phân loại
f = open("storage/stopword.txt",encoding = 'utf-8')
stopword=f.read()

def remove_stopwords(line):
    words = []
    for word in line.strip().split():
        if word not in stopword:
            words.append(word)
    return ' '.join(words)
def processing_data(data):
    data = gensim.utils.simple_preprocess(data)
    data = ' '.join(data)
    data = ViTokenizer.tokenize(data)
    data=remove_stopwords(data)
    return data


f = open("storage/input.txt",encoding = 'utf-8')
input=f.read()
str=input

xxx=[]
xxx.append(processing_data(str))

tfidf_vect_ngram = pickle.load(open(r'module/tfidf_vect_ngram_fit.pkl', 'rb'))
xxx_tfidf_ngram = tfidf_vect_ngram.transform(xxx)

svd_ngram = pickle.load(open(r'module/svd_ngram_fit.pkl', 'rb'))
xxx_tfidf_ngram_svd = svd_ngram.transform(xxx_tfidf_ngram)

model = pickle.load(open(r'module/AI.pkl', 'rb'))
final = model.predict(xxx_tfidf_ngram_svd)

f = open("storage/output.txt", "w")
f.write(final[0].__str__())