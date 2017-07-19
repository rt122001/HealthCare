import csv
import itertools
import sys
import pandas as pd
import random
import json
def generate_itemsets(itemsets,buckets,pass_):
	""" Generates different combinations of items in every pass of a-priori.
		Sends it to get_support() to get the support of each of these combinations 
		and see whether the support is greater than the support threshold."""
	if pass_ == 1:
		list_ = []
		for bucket in buckets:
			list_ = list_ + bucket

		items= set(list_)
		get_support(items,buckets,pass_)

	else:
		items = []
		for i in itemsets:
			if type(i) is list:
				for itr in i:
					if itr not in items:
						items.append(itr)
			else:
				items.append(i)

		cmb = itertools.combinations(items,pass_)
		list_ = [list(elem) for elem in cmb]

		print "LIST BEGIN"
		print list_
		
		get_support(list_,buckets,pass_)

def get_support(items,buckets,pass_):
	"""Extract support values for every itemset.
		Stores and passes them to frequent_itemsets.
	"""
	dict_main = {}
	ctr = 0
	for i in items:
		dict_main[ctr] = i
		ctr = ctr + 1

	dict_ = {}
	for key,values in dict_main.iteritems():
		dict_[key] = 0
		for bucket in buckets:
			if type(values) is list:
				if all(val in bucket for val in values):
					dict_[key] = int(dict_[key]) + 1
			else:
				if values in bucket:
					dict_[key] = int(dict_[key]) + 1

	
	frequent_itemset = frequent_itemsets(dict_,pass_)

	frequent = []
	for f in frequent_itemset:
		frequent.append(dict_main[f])

	print frequent

	if frequent_itemset:
		pass_ = pass_ + 1
		generate_itemsets(frequent,buckets,pass_)
	else: 
		print "A-priori passes completed."

def frequent_itemsets(dict_,pass_):
	""" Decides whether the itemset is Frequent or not.
		Edit the Support threshold required for the chaffing here.
	"""
	frequent = []
	for key,value in dict_.iteritems():
		if value>8:
			frequent.append(key)
	return frequent

def calculate_confidence(X,Y,buckets):
	occr_X = 0
	occr_Y = 0
	for bucket in buckets:
		if type(X) is list:
			if all(val in bucket for val in X):
				occr_X = int(occr_X) + 1
		else:
			if X in bucket:
				occr_X = int(occr_X) + 1

		if type(Y) is list:
			if all(val in bucket for val in Y):
				occr_Y = int(occr_Y) + 1
		else:
			if Y in bucket:
				occr_Y = int(occr_Y) + 1

	print "X: ",X
	print "Y: ",Y

	print "Occurrence of X: ",occr_X
	print "Occurrence of Y: ",occr_Y

	conf  = float(occr_Y)/float(occr_X)*100
	print "Confidence given X implies Y: ", conf,"%"
	return conf

def get_disease(symptomlist,buckets):
	disease_score={}
	score = 0
	for bucket in buckets:
		score = set(symptomlist) & set(bucket)
		score = float(len(score))/float(len(symptomlist))*100
		if score>0:
			print score
			disease = get_disease_given_bucket(bucket)
			print disease
			disease_score[disease] = score
	print disease_score

	with open("/Library/WebServer/Documents/htdocs/hospital3/healthcareproject/a-priori/disease_probabilityscores_from_symptomlist.csv","wb") as csvfile:
		writer = csv.writer(csvfile)

		#writer.writerow(["Symptomlist"])
		#writer.writerow(symptomlist)
		writer.writerow(["Disease","Probability scores"])
		for key,value in disease_score.iteritems():
			writer.writerow([key,value])

	df = pd.read_csv("/Library/WebServer/Documents/htdocs/hospital3/healthcareproject/a-priori/disease_probabilityscores_from_symptomlist.csv")
	result = df.sort_values("Probability scores",ascending=[False])
	score_dropped = result['Disease']
	final_csv = score_dropped[:3].to_csv('final.csv',index=False)
	test = pd.DataFrame(data=score_dropped[:3],index=None)
	test1 = test.reset_index()
	test1 = test1.drop('index',1)
	colnames = ["Col-%s" % x for x in xrange(1,20)]
	dis_sym_df = pd.read_csv("/Library/WebServer/Documents/htdocs/hospital3/healthcareproject/a-priori/bucketmap.csv",names=None,header=None)

	disease = []
	lis = []
	for i in range(len(test1)):
		x = test1['Disease'][i]
		y = dis_sym_df.loc[dis_sym_df[0] == x].values.tolist()
		lis.append(y[0][1:])
		disease.append(x)
	
	final = []
	one = list(set(lis[0])-set(lis[1]) - set(lis[2]))
	final.append(one)
	two = list(set(lis[1])-set(lis[2]) - set(lis[0]))
	final.append(two)
	three = list(set(lis[2])-set(lis[0]) - set(lis[1]))
	final.append(three)

	union = list(set(one).union(two).union(three))
	final_dict = {}

	union_dict = {}
	
	for i in range(len(final)):
		final_dict[disease[i]] = final[i]
	

	for key in final_dict:
		for i in range(len(final_dict[key])):
			union_dict[final_dict[key][i]] = key
	# print json.dumps(union_dict,indent=4)
	# asd = pd.DataFrame.from_dict(data=union_dict,orient='index')
	# print asd
	# asd.to_csv("/Library/WebServer/Documents/htdocs/hospital3/healthcareproject/a-priori/union.csv")
	with open("/Library/WebServer/Documents/htdocs/hospital3/healthcareproject/a-priori/union.csv","wb") as csvfile:
		writer = csv.writer(csvfile)

		#writer.writerow(["Symptomlist"])
		#writer.writerow(symptomlist)
		for key,value in union_dict.iteritems():
			writer.writerow([key,value])
	

"""Assuming every bucket uniquely points to a disease"""
def get_disease_given_bucket(bucket):
	disease = ""
	print "ENTER"
	with open("/Library/WebServer/Documents/htdocs/hospital3/healthcareproject/a-priori/bucketmap.csv","rb") as csvfile:
		reader = csv.reader(csvfile)
		for row in reader:
			row_clean = [i for i in row if i]
			bucket_clean = [i for i in bucket if i]
			if len(row_clean) == (len(bucket_clean)+1):
				if all(values in row_clean for values in bucket_clean):
					disease = row_clean[0]
					break

	return disease

buckets = []

with open("/Library/WebServer/Documents/htdocs/hospital3/healthcareproject/a-priori/buckets.csv") as csvfile:
	reader = csv.reader(csvfile)

	for row in reader:
		buckets.append(row)




pass_ = 1
itemsets = []
#generate_itemsets(itemsets,buckets,1)
#calculate_confidence("suicidal","fall",buckets)

symptomlist=[]
symptomlist.append(sys.argv[1])
symptomlist.append(sys.argv[2])
symptomlist.append(sys.argv[3])
get_disease(symptomlist,buckets)


