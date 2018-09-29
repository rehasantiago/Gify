#!C:\\Users\\dell\\AppData\\Local\\Programs\\Python\\Python36\\python.exe
import cv2
import os
import imageio
def getSizedFrame(width, height):   
    s, img = self.cam.read()
    if s:
            img = cv2.resize(img, (width, height), interpolation = cv2.INTER_AREA)
    return s, img
images=[]
for filename in os.listdir("C:\\xampp\\htdocs\\uploads\\upload"):
    img=cv2.imread(os.path.join("C:\\xampp\\htdocs\\uploads\\upload",filename))
    img=cv2.resize(img,(612,380))
    if img is not None:
        images.append(img)

fourcc=cv2.VideoWriter_fourcc(*'XVID')#cv2.VideoWriter_fourcc('X','V','I','D') 
video=cv2.VideoWriter('output2.avi',fourcc,1,(612,380))


for frame in images:
    video.write(frame)
cv2.destroyAllWindows()
video.release()


targetFormat=".gif"
inputpath='C:\\xampp\\htdocs\\uploads\\output2.avi'
outputpath = os.path.splitext(inputpath)[0] + targetFormat
video=imageio.get_reader(inputpath)
fps =video.get_meta_data()['fps']
video1=imageio.get_writer(outputpath,fps=fps)
for i,image in enumerate(video):
    video1.append_data(image)
video1.close()